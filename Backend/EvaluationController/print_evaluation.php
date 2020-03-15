<?php
require_once ("../../TCPDF/tcpdf.php");
require_once("../classes/DBhandler.php");
require_once("../classes/Group.php");
require_once("../classes/Criterion.php");
require_once("../classes/Evaluation.php");




if(false){
	header("Location: ../404.php");

}else{
	$panelid = $_POST["panelid"];
	//$group = DBHandler::GetGroup($_POST['groupid']);
	// //$scores = $_POST['Scores'];
	// //$comment = $_POST['Comment'];
	// $adviser = DBHandler::GetGroupFaculty($group->id, 1);
	$criteria = DBHandler::GetCriteria();
	//$eval = DBHandler::GetEvaluation($panelid, $group->id);

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
				<th class ="text-center">100</th>

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
				<th class ="text-center">100</th>

		</tr>';
	}

	$html.='</table>';


	$pdf->WriteHTMLCell(200, 0, '', '', $html, 0,1);

	//----------------------------------PAGE 2-----------------------------
	$pdf->AddPage();

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
				<th class ="text-center">100</th>

		</tr>';
	}

	$html .= '</table>';
	$pdf->WriteHTMLCell(200, 0, '', '', $html, 0,1);


	$pdf->Output("Evaluation.pdf", "I");
}


?>