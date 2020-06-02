<?php

    use Jaspersoft\Client\Client;

    $report = new Client(
				config("app.JASPERSOFT_HOST"),
				config("app.JASPERSOFT_USERNAME"),
				config("app.JASPERSOFT_PASSWORD"),
				"",
			);	

	$pdf = $report->reportService()->runReport($report_path, 'pdf', null, null, $controls);

	echo $pdf;
	
?>