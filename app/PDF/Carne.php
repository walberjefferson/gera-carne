<?php

namespace App\PDF;

class Carne extends AbstractPdf
{
    private $dados;

    public function __construct($dados, $orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);
        $this->dados = $dados;
    }

    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    public function setSubTitulo($subtitulo)
    {
        $this->subTitulo = $subtitulo;
    }

    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function setFileName($name)
    {
        $this->fileName = $name;
    }

    public function setDestino($dest)
    {
        $this->destino = $dest;
    }

    public function create()
    {
        $this->AddPage();
        $this->SetAutoPageBreak(true, 0);
        $this->SetFillColor(100, 100, 100);

        foreach ($this->dados['vencimento'] as $c => $vencimento) {
            $parcela = $c + 1;
            if ($this->GetY() > 70) $this->Ln(8);
            $this->carne($parcela, $this->dados['valor'][$c], $vencimento);
        }

    }

    protected function carne($parcela, $valor, $vencimento)
    {
        $loja = lojas()->get($this->dados['loja']);
        $cliente = $this->dados['nome'];
        $n_nota = $this->dados['numero_nota'];
        $vendedor = $this->dados['vendedor'];
        $observacoes = $this->dados['observacoes'];
        $total_parcelas = count($this->dados['vencimento']);

        $this->Rect(10, $this->GetY() - 1.5, 190, 65);
        $this->Line(107.5, $this->GetY(), 107.5, $this->GetY() + 62);

        $this->SetFont('Arial', 'B', 20);
        $this->SetX(21);
        $this->Cell(82, 7, fpdf_utf8_uppercase($loja), '', 0, 'C', 0);
        $this->SetX($this->GetX() + 9);
        $this->Cell(82, 7, fpdf_utf8_uppercase($loja), '', 1, 'C', 0);

        $this->SetFont('Arial', 'B', 12);
        $this->SetX(21);
        $this->Cell(82, 6, fpdf_utf8_uppercase("comprovante de pagamento"), '', 0, 'C', 0);
        $this->SetX($this->GetX() + 9);
        $this->Cell(82, 6, fpdf_utf8_uppercase("comprovante de pagamento"), '', 1, 'C', 0);

        $this->SetFont('Arial', 'B', 10);
        $this->SetX(21);
        $this->Cell(14, 5, fpdf_utf8("Cliente:"), '', 0, 'L', 0);
        $this->SetFont('Arial', 'U', 10);
        $this->Cell(68, 5, str_limit(fpdf_utf8($cliente), 39, ''), '', 0, 'L', 0);
        $this->SetX($this->GetX() + 9);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(14, 5, fpdf_utf8("Cliente:"), '', 0, 'L', 0);
        $this->SetFont('Arial', 'U', 10);
        $this->Cell(68, 5, str_limit(fpdf_utf8($cliente), 39, ''), '', 1, 'L', 0);

        $this->SetFont('Arial', 'B', 10);
        $this->SetX(21);
        $this->Cell(25, 5, fpdf_utf8("Nº da Parcela:"), '', 0, 'L', 0);
        $this->SetFont('Arial', 'U', 10);
        $this->Cell(57, 5, str_limit(fpdf_utf8("{$parcela} / {$total_parcelas}"), 39, ''), '', 0, 'L', 0);
        $this->SetX($this->GetX() + 9);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(25, 5, fpdf_utf8("Nº da Parcela:"), '', 0, 'L', 0);
        $this->SetFont('Arial', 'U', 10);
        $this->Cell(57, 5, str_limit(fpdf_utf8("{$parcela} / {$total_parcelas}"), 39, ''), '', 1, 'L', 0);

        $this->SetFont('Arial', 'B', 10);
        $this->SetX(21);
        $this->Cell(22, 5, fpdf_utf8("Vencimento:"), '', 0, 'L', 0);
        $this->SetFont('Arial', 'U', 10);
        $this->Cell(60, 5, str_limit(fpdf_utf8("{$vencimento}"), 39, ''), '', 0, 'L', 0);
        $this->SetX($this->GetX() + 9);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(22, 5, fpdf_utf8("Vencimento:"), '', 0, 'L', 0);
        $this->SetFont('Arial', 'U', 10);
        $this->Cell(60, 5, str_limit(fpdf_utf8("{$vencimento}"), 39, ''), '', 1, 'L', 0);

        $this->SetFont('Arial', 'B', 10);
        $this->SetX(21);
        $this->Cell(35, 5, fpdf_utf8("Data de Pagamento:"), '', 0, 'L', 0);
        $this->SetFont('Arial', '', 10);
        $this->Cell(47, 5, str_limit(fpdf_utf8("___/___/______"), 39, ''), '', 0, 'L', 0);
        $this->SetX($this->GetX() + 9);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(35, 5, fpdf_utf8("Data de Pagamento:"), '', 0, 'L', 0);
        $this->SetFont('Arial', '', 10);
        $this->Cell(47, 5, str_limit(fpdf_utf8("___/___/______"), 39, ''), '', 1, 'L', 0);

        $this->SetFont('Arial', 'B', 10);
        $this->SetX(21);
        $this->Cell(11, 5, fpdf_utf8("Valor:"), '', 0, 'L', 0);
        $this->SetFont('Arial', 'U', 10);
        $this->Cell(71, 5, str_limit(fpdf_utf8("R$ {$valor}"), 39, ''), '', 0, 'L', 0);
        $this->SetX($this->GetX() + 9);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(11, 5, fpdf_utf8("Valor:"), '', 0, 'L', 0);
        $this->SetFont('Arial', 'U', 10);
        $this->Cell(71, 5, str_limit(fpdf_utf8("R$ {$valor}"), 39, ''), '', 1, 'L', 0);

        $this->SetFont('Arial', 'B', 10);
        $this->SetX(21);
        $this->Cell(24, 5, fpdf_utf8("Correção: R$"), '', 0, 'L', 0);
        $this->SetFont('Arial', 'U', 10);
        $this->Cell(30, 4.5, "", 'B', 0, 'L', 0);
        $this->SetX($this->GetX() + 9 + 28);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(24, 5, fpdf_utf8("Correção: R$"), '', 0, 'L', 0);
        $this->SetFont('Arial', 'U', 10);
        $this->Cell(30, 4.5, "", 'B', 1, 'L', 0);

        $this->SetFont('Arial', 'B', 10);
        $this->SetX(21);
        $this->Cell(17, 5, fpdf_utf8("Total: R$"), '', 0, 'L', 0);
        $this->SetFont('Arial', 'U', 10);
        $this->Cell(30, 4.5, "", 'B', 0, 'L', 0);
        $this->SetX($this->GetX() + 9 + 35);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(17, 5, fpdf_utf8("Total: R$"), '', 0, 'L', 0);
        $this->SetFont('Arial', 'U', 10);
        $this->Cell(30, 4.5, "", 'B', 1, 'L', 0);

        $this->SetFont('Arial', 'B', 10);
        $this->SetX(21);
        $this->Cell(20, 5, fpdf_utf8("Nº da Nota:"), '', 0, 'L', 0);
        if ($n_nota) {
            $this->SetFont('Arial', 'U', 10);
            $this->Cell(30, 5, fpdf_utf8($n_nota), '', 0, 'L', 0);
        } else {
            $this->SetFont('Arial', '', 10);
            $this->Cell(30, 4.5, "", 'B', 0, 'L', 0);
        }
        $this->SetX($this->GetX() + 9 + 32);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(20, 5, fpdf_utf8("Nº da Nota:"), '', 0, 'L', 0);
        if ($n_nota) {
            $this->SetFont('Arial', 'U', 10);
            $this->Cell(30, 5, fpdf_utf8($n_nota), '', 1, 'L', 0);
        } else {
            $this->SetFont('Arial', '', 10);
            $this->Cell(30, 4.5, "", 'B', 1, 'L', 0);
        }

        $this->SetFont('Arial', 'B', 10);
        $this->SetX(21);
        $this->Cell(25, 5, fpdf_utf8("Observações:"), '', 0, 'L', 0);
        if ($observacoes) {
            $this->SetFont('Arial', 'U', 10);
            $this->Cell(57, 5, str_limit(fpdf_utf8($observacoes), 39, ''), '', 0, 'L', 0);
        } else {
            $this->SetFont('Arial', '', 10);
            $this->Cell(57, 4.5, "", 'B', 0, 'L', 0);
        }
        $this->SetX($this->GetX() + 9);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(25, 5, fpdf_utf8("Observações:"), '', 0, 'L', 0);
        if ($observacoes) {
            $this->SetFont('Arial', 'U', 10);
            $this->Cell(57, 5, str_limit(fpdf_utf8($observacoes), 39, ''), '', 1, 'L', 0);
        } else {
            $this->SetFont('Arial', '', 10);
            $this->Cell(57, 4.5, "", 'B', 1, 'L', 0);
        }


        $this->SetFont('Arial', 'B', 10);
        $this->SetX(21);
        $this->Cell(19, 5, fpdf_utf8("Vendedor:"), '', 0, 'L', 0);
        if ($vendedor) {
            $this->SetFont('Arial', 'U', 10);
            $this->Cell(63, 5, fpdf_utf8($vendedor), '', 0, 'L', 0);
        } else {
            $this->SetFont('Arial', '', 10);
            $this->Cell(63, 4.5, "", 'B', 0, 'L', 0);
        }
        $this->SetX($this->GetX() + 9);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(19, 5, fpdf_utf8("Vendedor:"), '', 0, 'L', 0);
        if ($vendedor) {
            $this->SetFont('Arial', 'U', 10);
            $this->Cell(63, 5, fpdf_utf8($vendedor), '', 1, 'L', 0);
        } else {
            $this->SetFont('Arial', '', 10);
            $this->Cell(63, 4.5, "", 'B', 1, 'L', 0);
        }

        if ($this->GetY() > 276) {
            $this->AddPage();
            $this->SetAutoPageBreak(true, 0);
        }


    }

    public function Header()
    {

    }

    public function Footer()
    {
    }
}
