<?php
use ianring\PHPMusicXML;

error_reporting(E_ALL);
ini_set('display_errors', 1);

//require_once SITE_ROOT . '/current/vendor/autoload.php';

require_once '../PHPMusicXML.php';

$score = new Score();
$part = new Part('Viola');

$scale = new Scale(array(
  'root' => new Pitch('D4'),
  'mode' => 'lydian augmented',
));

$pitches = $scale->getPitches();

$measure = new Measure();
foreach ($pitches as $pitch) {
  $measure->addNote(new Note(array(
    'pitch' => $pitch,
    'duration' => 4
  )));
}
$part->addMeasure($measure);

$scale->setProperty('mode', 'bebop dominant');
$pitches = $scale->getPitches();

$measure = new Measure();
foreach ($pitches as $pitch) {
  $measure->addNote(new Note(array(
    'pitch' => $pitch,
    'duration' => 4
  )));
}
$part->addMeasure($measure);


$score->addPart($part);
$part->addMeasure($measure);
$xml2 = $score->toXML('partwise');

?><html>
<head>
    <meta name="viewport" content="initial-scale = 1.0, minimum-scale = 1.0, maximum-scale = 1.0, user-scalable = no">

<script src="vexflow/jquery.js"></script>
<script src="vexflow/vexflow-debug.js"></script>

    <script>
	$(document).ready(function() {

		var xml2 = '<?php echo $xml2; ?>';
		var doc = null;
		doc = new Vex.Flow.Document(xml2);
		doc.getFormatter().setWidth(800).draw($("#viewer2")[0]);

	});

    </script>
    <style>
      #viewer {
        width: 100%;
        overflow: hidden;
      }
    </style>
  </head>
  <body>

    <div id="viewer2">
      <p>Please enable JavaScript to use the viewer.</p>
    </div>

    <textarea style="width:800px;height:400px;">
    	<?php echo htmlspecialchars($xml2); ?>
    </textarea>

  </body>
</html>
