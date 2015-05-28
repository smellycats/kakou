<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_bar.php');

// Some data
//$datay=array(3,7,19,11,4,20);
//$datay = array(233334,133334,533334,633334,433334,333334);
//$datay = $count;

// Create the graph and setup the basic parameters 
$graph = new Graph(700,350,'auto');	
$graph->img->SetMargin(60,30,60,40);
$graph->SetScale("textint");
$graph->SetFrame(true,'blue',1); 
$graph->SetColor('lightblue');
$graph->SetMarginColor('lightblue');

// Add some grace to the top so that the scale doesn't
// end exactly at the max value. 
//$graph->yaxis->scale->SetGrace(20);

// Setup X-axis labels
//$a = $gDateLocale->GetShortMonth();
//$a = array("����1","����2","����3","����4","����5","����6");
$graph->xaxis->SetTickLabels($name);
$graph->xaxis->SetFont(FF_SIMSUN);
$graph->xaxis->SetColor('darkblue','black');

// Stup "hidden" y-axis by given it the same color
// as the background
$graph->yaxis->SetColor('white','darkblue');
$graph->ygrid->SetColor('white');

// Setup graph title ands fonts
$title= "�ܼƣ�" . $total . "��";
$graph->title->Set($title);
$graph->subtitle->SetFont(FF_SIMSUN,FS_BOLD,10);
$graph->subtitle->Set('(��״ͳ��ͼ)');

$graph->title->SetFont(FF_SIMSUN,FS_BOLD,16);
$graph->xaxis->title->Set(" ");
$graph->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
                              
// Create a bar pot
$bplot = new BarPlot($datay);
$bplot->SetFillColor('orange');
$bplot->SetColor('darkblue');
$bplot->SetWidth(0.5);
$bplot->SetShadow('darkgray');

// Setup the values that are displayed on top of each bar
$bplot->value->Show();
// Must use TTF fonts if we want text at an arbitrary angle
//���������ͼ�ϵ����ִ�С
$bplot->value->SetFont(FF_SIMSUN,FS_NORMAL,12);
$bplot->value->SetFormat('%d ��');
// Black color for positive values and darkred for negative values
$bplot->value->SetColor("black","darkred");
$graph->Add($bplot);

// Finally stroke the graph
$graph->Stroke();
?>

