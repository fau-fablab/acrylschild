<?php

// Convert values to int for rudimentary code injection prevention

$width = intval($_GET["breite"]);
$thickness = intval($_GET["staerke"]);

// create a unique id
$id = uniqid();

// enable or disable test mode
$test = false;

// create a unique folder for saving the files
mkdir("files/" . $id , 0700);
for($i = 1; $i < 5; $i++) {
	$layer = $i;
	
	// create svg content
	$svg = '
	<svg
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:cc="http://creativecommons.org/ns#"
	xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
	xmlns:svg="http://www.w3.org/2000/svg"
	xmlns="http://www.w3.org/2000/svg"
	xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
	version="1.0"
	width="609mm"
	height="304mm"
	viewBox="0 0 609 304"
	id="svg2"
	sodipodi:docname="Bodenplatte Acrylschild Layer4 8mm.svg">
	<metadata id="metadata2961">
		<rdf:RDF>
			<cc:Work rdf:about="">
				<dc:format>image/svg+xml</dc:format>
				<dc:type rdf:resource=
					"http://purl.org/dc/dcmitype/StillImage" />
				<dc:title></dc:title>
			</cc:Work>
		</rdf:RDF>
	</metadata>
	<defs></defs>
	<g style="color:#000000; fill:none; stroke:#000000; stroke-width:0.1;
	stroke-linecap:butt; stroke-linejoin:miter; stroke-miterlimit:4;
	stroke-opacity:1; stroke-dasharray:none; stroke-dashoffset:0; marker:none;
	visibility:visible; display:inline; overflow:visible;
	enable-background:accumulate">
	<rect rx="8.85" ry="8.85" y="1.287" x="1.287" height="48"
	width="' . ($width + 13.6) . '"/>';

	// Draw a rectangular slot to hold the picture plate
	if($layer == 3 || $layer == 4 || $test) {
		$svg .= '<rect y="' . (25.287 - (($thickness-0.13)/ 2)) .
			'" x="8.087" height="' . ($thickness-0.13) .
				'" width="' . ($width) . '" />';
	}

	// Draw hexagonal holes for nuts
	if($layer == 1 || $test) {
		$svg .= '<path d="M15.33 9.287 l3.12 0 l1.55 2.6 l-1.55 2.69 l-3.12 0  l-1.55 -2.69 Z" />
				 <path d="M15.33 35.901 l3.12 0 l1.55 2.69 l-1.55 2.69 l-3.12 0  l-1.55 -2.69 Z" />
				 <path d="M' . ($width-0.563) . ' 35.901 l3.12 0 l1.55 2.69 l-1.55 2.69 l-3.12 0  l-1.55 -2.69 Z" />
				 <path d="M' . ($width-0.563) . ' 9.287 l3.12 0 l1.55 2.69 l-1.55 2.69 l-3.12 0  l-1.55 -2.69 Z" />';
	}

	// Draw holes for screws
	if($layer == 3 || $layer == 2 || $test) {
		$svg .= '"<circle cx="16.889" cy="11.981" r="1.4315"/>
				<circle cx="16.889" cy="38.595" r="1.4315"/>
				<circle cx="' . ($width+0.996) . '" cy="11.981" r="1.4315"/>
				<circle cx="' . ($width+0.996) . '" cy="38.595" r="1.4315"/>';
	}

	// Draw cutouts for cabling and led stripe
	if($layer == 2 || $test) {
		$svg .= '<rect y="1.287" x="20.13" height="5" width="5.1" />
			<rect y="15.11" x="6.17" height="15" width="56.64" />
		<rect y="20.478" x="62.81" height="9.632" width="' . ($width - 51.714) . '" />
		<rect y="6.287" x="20.13" height="8.86" width="42.68" />';
	}
	$svg .= "
		</g>
	</svg>";

	// Write the created svg to a file
	$datei = fopen("files/" . $id . "/Layer" . $layer . ".svg","w");
	fwrite($datei, $svg);
	fclose($datei);
}


// Pack the created files into a zip file
// error handling needs to be implemented lateron...

$zipdest = "files/" . $id . "/Bodenplatte Acrylschild.zip";
$zip = new ZipArchive();
$zip->open($zipdest, ZIPARCHIVE::CREATE);
$zip->addFile("files/" . $id . "/Layer1.svg", "Layer1.svg");
$zip->addFile("files/" . $id . "/Layer2.svg", "Layer2.svg");
$zip->addFile("files/" . $id . "/Layer3.svg", "Layer3.svg");
$zip->addFile("files/" . $id . "/Layer4.svg", "Layer4.svg");
$zip->close();
?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="UTF-8">
		<title>Acrylschild - Designer</title>
		<style type="text/css" media="all">@import "style.css";</style>
	</head>

	<body>

		<h1 id="Header">Acrylschild - Designer</h1>
		<div class="Content">
			<p>Dieser Assistent soll dabei behilflich sein, einen Standfuß für die mit dem
					Laser-Cutter erstellten Leuchtschilder zu erstellen. Dies kann sehr
					Zeitaufwändig sein und zu Stoßzeiten den Betrieb aufhalten. Daher bitte wenn
					möglich dieses Tool verwenden.</p>
			<br />

			<!-- page 1 -->
			<p id="page1">
			1. Teil: Angaben zum Leuchtschild | 2. Teil: Erstellen der Dateien | <b>3.
					Teil: Download der erstellten Dateien</b><br />

			<br />

			<a href="files/<?php echo $id;?>/Layer1.svg">
					Bodenplatte Acrylschild Layer1 3mm</a><br />
			<a href="files/<?php echo $id;?>/Layer2.svg">
					Bodenplatte Acrylschild Layer2 3mm</a><br />
			<a href="files/<?php echo $id;?>/Layer3.svg">
					Bodenplatte Acrylschild Layer3 8mm</a><br />
			<a href="files/<?php echo $id;?>/Layer4.svg">
					Bodenplatte Acrylschild Layer4 3mm</a><br />
			<br />
			<br />
			<a href="files/<?php echo $id;?>/Bodenplatte Acrylschild.zip">
					Download aller erstellten Dateien als Zip-Archiv</a>
			</p>

		</div>

	</body>
</html>
