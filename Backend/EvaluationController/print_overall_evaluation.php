<?php
require_once ("../../TCPDF/tcpdf.php");
require_once("../classes/DBhandler.php");
require_once("../classes/Group.php");
require_once("../classes/Criterion.php");
require_once("../classes/Evaluation.php");
session_start();
//header("Content-type: application/pdf");

if(!isset($_SESSION["Account"])){
	header("Location: ../login.php");
}
else if(!isset($_GET['groupid'])){
	header("Location: ../404.php");

}else{
	//$panel = DBHandler::GetAccountInfo($_GET['panelid']);
	$group = DBHandler::GetGroup($_GET['groupid']);
	$members = DBHandler::GetGroupMembers($group->id);
	$adviser = DBHandler::GetGroupFaculty($group->id, 1);
	$prof = DBHandler::GetGroupFaculty($group->id, 4);
	$criteria = DBHandler::GetCriteria();
	$eval = DBHandler::GetOverallGrades($group->id);
	$panels = array_merge(DBHandler::GetGroupFaculty($group->id, 2), DBHandler::GetGroupFaculty($group->id, 3));

	$pdf = new TCPDF();

	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	$pdf->SetMargins(5,3,0,false);
	$pdf->AddPage();
	$pdf->Cell(210, 10, "RUBRICS FOR THESIS with SOFTWARE/CAPSTONE PROJECT PRESENTATION",0 ,1,"C");

	$font_size = $pdf->pixelsToUnits('28');
	$pdf->SetFont ('helvetica', '', $font_size , '', 'default', true );

	$html = '
	<style>
		th,td{
			border:1px solid #000;
			padding:2px;
		}
		.text-center{
			text-align:center;
		}
	</style>
	<table cellpadding="4">
		<tr>
			<th class = "text-center">Criteria</th>
			<th class = "text-center">Beginner<br>1</th>
			<th class = "text-center">Acceptable<br>2</th>
			<th class = "text-center">Proficient<br>3</th>
			<th class = "text-center">Exemplary<br>4</th>
			<th class = "text-center">Score</th>
		</tr>
		<tr>
			<th colspan="6" class = "text-center">DOCUMENTS</th>
		</tr>
	';

	for($x = 0; $x<3; $x++){
		$html.='<tr>
				<th class = "text-center">'.$criteria[$x]->title.'</th>
				<th>&#8226; '.$criteria[$x]->descriptions[0].'</th>
				<th>&#8226; '.$criteria[$x]->descriptions[1].'</th>
				<th>&#8226; '.$criteria[$x]->descriptions[2].'</th>
				<th>&#8226; '.$criteria[$x]->descriptions[3].'</th>
				<th class ="text-center">'.number_format($eval->grades[$x], 2,'.',',').'</th>

		</tr>';
	}

	$html .= '<tr><td colspan="6" class="text-center">PRESENTATION</td></tr>';

	for($x = 3; $x<5; $x++){
		$html.='<tr>
				<th class = "text-center">'.$criteria[$x]->title.'</th>
				<th>&#8226; '.$criteria[$x]->descriptions[0].'</th>
				<th>&#8226; '.$criteria[$x]->descriptions[1].'</th>
				<th>&#8226; '.$criteria[$x]->descriptions[2].'</th>
				<th>&#8226; '.$criteria[$x]->descriptions[3].'</th>
				<th class ="text-center">'.number_format($eval->grades[$x], 2,'.',',').'</th>

		</tr>';
	}

	$html.='</table>';


	$pdf->WriteHTMLCell(200, 0, '', '', $html, 0,1);

	//----------------------------------PAGE 2-----------------------------
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(False, 3);
	$font_size = $pdf->pixelsToUnits('26');
	$pdf->SetFont ('helvetica', '', $font_size , '', 'default', true );

	$html = '
	<style>
		th,td{
			border:1px solid #000;
			padding:2px;
		}
		.text-center{
			text-align:center;
		}
		.text-middle{
			vertical-align:center;
		}
	</style>
	<table cellpadding="4">
		<tr>
			<th class = "text-center" colspan="6">SOFTWARE</th>
		</tr>
	';

	for($x = 5; $x<10; $x++){
		$html.='<tr>';
		
		if($x == 5){
			$html.='<th class = "text-center" rowspan = "5" valign="bottom">Instructional Content</th>';
		}


		$html.=	'<th>&#8226; '.$criteria[$x]->descriptions[0].'</th>
				<th>&#8226; '.$criteria[$x]->descriptions[1].'</th>
				<th>&#8226; '.$criteria[$x]->descriptions[2].'</th>
				<th>&#8226; '.$criteria[$x]->descriptions[3].'</th>
				<th class ="text-center">'.number_format($eval->grades[$x], 2, '.',',').'</th>

		</tr>';
	}

	for($x = 10; $x<14; $x++){
		$html.='<tr>';
		
		if($x == 10){
			$html.='<th class = "text-center" rowspan = "4" valign="bottom">Layout</th>';
		}


		$html.=	'<th>&#8226; '.$criteria[$x]->descriptions[0].'</th>
				<th>&#8226; '.$criteria[$x]->descriptions[1].'</th>
				<th>&#8226; '.$criteria[$x]->descriptions[2].'</th>
				<th>&#8226; '.$criteria[$x]->descriptions[3].'</th>
				<th class ="text-center">'.number_format($eval->grades[$x], 2, '.',',').'</th>

		</tr>';
	}

	$html.='<tr>
				<th class = "text-center">'.$criteria[14]->title.'</th>
				<th>&#8226; '.$criteria[14]->descriptions[0].'</th>
				<th>&#8226; '.$criteria[14]->descriptions[1].'</th>
				<th>&#8226; '.$criteria[14]->descriptions[2].'</th>
				<th>&#8226; '.$criteria[14]->descriptions[3].'</th>
				<th class ="text-center">'.number_format($eval->grades[14], 2, '.',',').'</th>

		</tr>';

	$totalScore = array_sum($eval->grades);
	$rating = (($totalScore/60) * 50) + 50;
	$html .= '
	<tr>
		<td colspan = "3" rowspan = "4">
			Group Members: <br>';

	foreach($members as $m){
		$html.=$m->firstname.' '.$m->lastname.'<br>';
	}


	$panelString ="";
	foreach($panels as $p){
		$panelString.=$p->firstname." ".$p->lastname."<br>";
	}

	$html.= '
		</td>
		<td colspan = "3">Section: '.$group->section.'</td>
	</tr>
	<tr>
		<td colspan = "3">Professor: '.$prof[0]->firstname.' '.$prof[0]->lastname.'</td>
	</tr>
	<tr>
		<td colspan = "3">Adviser: '.$adviser[0]->firstname.' '.$adviser[0]->lastname.'</td>
	</tr>
	<tr>
		<td colspan = "3">Title: '.$group->title.'</td>
	</tr>

	<tr>
		<td colspan = "3" rowspan = "2">Panelists:<br>'.$panelString.'</td>
		<td colspan = "2">Overall Total Score: </td>
		<td class = "text-center">'.number_format($totalScore, 2, '.',',').'</td>
	</tr>
	<tr>
		<td colspan = "2">Overall Rating: </td>
		<td class="text-center">'.number_format($rating, 2, '.',',').'</td>
	</tr>

	';

	$html .= '</table>';
	$pdf->WriteHTMLCell(200, 0, '', '', $html, 0,1);

	//$evaluator = "Evaluated by: ";
	$currentDate = new DateTime($eval->date);
	$date = "Date: ";
	//$pdf->Cell(70, 10, $evaluator,0,0,'L');
	$pdf->Cell(15, 10, $date,0,0,'L');
	//$pdf->Cell(70, 5, $panel->firstname." ". $panel->lastname,0,0,'C');
	$pdf->Cell(30, 10, date_format($currentDate, "F d, Y"),0,1,'C');


	$pdf->Output("Evaluation.pdf", "I");
}


?>