<?php

namespace App\PDF;

use Codedge\Fpdf\Fpdf\Fpdf;

abstract class AbstractPdf extends Fpdf
{
    protected $widths;
    protected $aligns;

    protected $fileName;
    protected $destino;

    protected $titulo;
    protected $subTitulo;
    protected $logo;
    protected $total;


    public function __construct($orientation = 'L', $unit = 'mm', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);
        $this->destino = 'I';
        $this->fileName = 'doc.pdf';
    }

    abstract public function setTitulo($titulo);

    abstract public function setSubTitulo($subTitulo);

    abstract public function setLogo($logo);

    abstract public function setTotal($total);

    public function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->SetDrawColor(242, 242, 242);
        if (is_file($this->logo)) :
            $this->Image($this->logo, 10, 10, 23, 20);
            $this->SetXY(35, 10);
            $this->Cell(120, 6, strtoupper(utf8_decode("Prefeitura Municipal de Olho d'Água das Flores")), '0', 0, 'L', 0);
            $this->Cell(0, 6, utf8_decode($this->titulo), '0', 0, 'R');
            $this->SetXY(35, 15);
            $this->Cell(0, 8, utf8_decode("PROJETO PÉ NA BOLA"), '0', 0);

            $this->SetXY(10, 23.5);
        else:
            $this->SetXY(10, 10);
            $this->Cell(120, 6, strtoupper(utf8_decode("Prefeitura Municipal de Olho d'Água das Flores")), '0', 0, 'L', 0);
            $this->Cell(0, 6, utf8_decode($this->titulo), '0', 0, 'R');
            $this->SetXY(10, 15);
            $this->Cell(0, 8, utf8_decode("PROJETO PÉ NA BOLA"), '0', 0);
            $this->SetXY(10, 15);
        endif;
        $this->Cell(0, 8, "", 'B', 1);
        $this->Ln(1);

    }

    public function Footer()
    {
        $this->AliasNbPages();
        $this->SetY(-15);
        $this->SetTextColor(0, 0, 0);
        $this->SetDrawColor(242, 242, 242);
        $this->SetFont('Arial', 'I', 8);

        if (empty($this->total)) {
            $this->Cell(185, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 'T', 0, 'L');
            $this->Cell(92, 10, utf8_decode('Gerado em ') . utf8_decode(date('d/m/Y \à\s H:i:s')), 'T', 0, 'R');
        } else {
            $this->Cell(92, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 'T', 0, 'L');
            $this->Cell(93, 10, utf8_decode('Total de Registos: ') . $this->total, 'T', 0, 'C');
            $this->Cell(92, 10, utf8_decode('Gerado em ') . utf8_decode(date('d/m/Y \à\s H:i:s')), 'T', 0, 'R');
        }

    }

    public function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths = $w;
    }

    public function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    public function Row($data, $fill = false, $height = 5)
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h = $height * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {

            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, $height, $data[$i], 1, $a, $fill);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    public function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw =& $this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n") {
            $nb--;
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }
                } else {
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }

    public function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
        }
    }

    public function render()
    {
        $this->create();
        $this->Output($this->destino, $this->fileName);
        exit();
    }

    public function create()
    {

    }

}
