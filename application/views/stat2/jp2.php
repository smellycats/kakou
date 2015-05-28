<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_pie.php');

// Some data
//$data = array(233334,133334,533334,633334,433334,333334);
//$datax = array("卡口1","卡口2","卡口3","卡口4","卡口5","卡口6");

// A new graph
$graph = new PieGraph(700,400);
$graph->SetShadow();

// Setup title
$title= "总计：" . $total . "辆";
$graph->title->Set($title);
$graph->title->SetFont(FF_SIMSUN,FS_BOLD,16);
$graph->subtitle->SetFont(FF_SIMSUN,FS_BOLD,10);
$graph->subtitle->Set('(饼状统计图)');

// The pie plot
$p1 = new PiePlot($datay);

// Move center of pie to the left to make better room
// for the legend
$p1->SetCenter(0.35,0.5);

// No border
$p1->ShowBorder(false);

// Label font and color setup
$p1->value->SetFont(FF_SIMSUN,FS_BOLD,12);
$p1->value->SetColor("darkred");

// Use absolute values (type==1)
$p1->SetLabelType(PIE_VALUE_ABS);

// Label format
$p1->value->SetFormat("%d");
$p1->value->Show();

// Size of pie in fraction of the width of the graph
$p1->SetSize(0.3);

// Legends
foreach ($name as $id=>$x)
{
	$name[$id] = $x . " (%d)";
}
//$p1->SetLegends(array("May (%d)","June (%d)","July (%d)","Aug (%d)"));
$graph -> legend -> SetFont(FF_SIMSUN,FS_NORMAL); 
$p1->SetLegends($name);
$graph->legend->Pos(0.05,0.15);

$graph->Add($p1);
$graph->Stroke();
?>