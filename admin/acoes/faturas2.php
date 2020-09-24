<?php  
require_once('../../bd.php'); 
require_once('../tcpdf/tcpdf.php'); 
if(isset($_POST["create_pdf"]) && $_POST['create_pdf']=="Create_pdf")  
{  
    
    $sql_perfil4=$conn->query("select * from reservas where idreserva='".$_GET['res']."' and estadia_conc<>0")or die("Erro ao selecionar o nome.");
    if($sql_perfil4->num_rows>=1){ 
        $row3=$sql_perfil4->fetch_assoc();

            $nome = $row3['nome_final'];
            $email = $row3['email_final'];
            $datai = $row3['datai'];
            $dataf = $row3['dataf'];
            $num_adult = $row3['num_adults'];
            $num_child = $row3['num_child'];
            $preco_total = number_format($row3['preco_total'], 2);
            $fee = $row3['paypal_fee'];
            $preco = number_format($row3['preco_total'] - $fee, 2);
            $data_pag = $row3['data_pagamento'];

        $sql_perfil5=$conn->query("select nome,email from utilizadores where idutilizador='".$row3['idutilizador']."'")or die("Erro ao selecionar o nome.");
        if($sql_perfil5->num_rows>=1){ 
            $row4=$sql_perfil5->fetch_assoc();

            $nome = $row4['nome'];
            $email = $row4['email'];

        } else {
            $nome = $row3['nome_final'];
            $email = $row3['email_final'];
        }

        $cont=$conn->query("select * from contactos")or die("Erro ao selecionar o nome.");
        $rowc=$cont->fetch_assoc();

        $data=$conn->query("select CURRENT_TIMESTAMP() as data")or die("Erro ao selecionar o nome.");
        $cur_date=$data->fetch_assoc();

        $data_p=$conn->query("select day('".$data_pag."') as dia, month('".$data_pag."') as mes, year('".$data_pag."') as ano")or die("Erro ao selecionar o nome.");
        $data_p2=$data_p->fetch_assoc();

        $data_at=$conn->query("select day('".$cur_date['data']."') as dia, month('".$cur_date['data']."') as mes, year('".$cur_date['data']."') as ano")or die("Erro ao selecionar o nome.");
        $data_at2=$data_at->fetch_assoc();

    $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $obj_pdf->SetCreator(PDF_CREATOR);  
    $obj_pdf->SetTitle("Export HTML Table data to PDF using TCPDF in PHP");  
    $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
    $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $obj_pdf->SetDefaultMonospacedFont('helvetica');  
    $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
    $obj_pdf->setPrintHeader(false);  
    $obj_pdf->setPrintFooter(false);  
    $obj_pdf->SetAutoPageBreak(TRUE, 10);  
    $obj_pdf->SetFont('helvetica', '', 12);  
    $obj_pdf->AddPage();  
    
    $obj_pdf->writeHTMLCell(32, 32, 20, 10, '<img src="../logo/logofinal.png" />');
    $obj_pdf->writeHTMLCell(70, 10, 20, 70, '<div style="">São Gregório Alojamento Local</div>');
    $obj_pdf->writeHTMLCell(60, 10, 20, 78, '<div style="">'.$rowc['morada'].'</div>');
    //Data de emição
    $obj_pdf->writeHTMLCell(50, 10, 150, 20, '<div style="text-align: right;">Nº da fatura: '.$row3['idreserva'].'</div>');
    $obj_pdf->writeHTMLCell(100, 10, 100, 28, '<div style="text-align: right;">Data de pagamento: '.$data_pag.'</div>');
    $obj_pdf->writeHTMLCell(80, 10, 120, 36, '<div style="text-align: right;">Emitido em: '.$cur_date['data'].'</div>');
    //Utilizador
    $obj_pdf->writeHTMLCell(80, 10, 120, 70, '<div style="text-align: right;">Denise Lima</div>');
    $obj_pdf->writeHTMLCell(80, 10, 120, 78, '<div style="text-align: right;">'.$rowc['email'].'</div>');
    //Método de Pagamento
    $obj_pdf->writeHTMLCell(80, 10, 25, 112, '<span style="color: #ffffff; font-size: 15px; font-weight: 550;">Método de Pagamento</span>');
    $obj_pdf->writeHTMLCell(180, 10, 20, 110, '<div style="background-color: #c1c9b6; text-align: left;"></div>');
    $obj_pdf->writeHTMLCell(180, 10, 20, 112, '<div style="background-color: #c1c9b6; text-align: left;"></div>');
    $obj_pdf->writeHTMLCell(180, 10, 20, 116, '<div style="background-color: #c1c9b6; border-bottom: 1.5px solid #6f7d5d; text-align: left;"></div>');
    //Método de Pagamento 2
    $obj_pdf->writeHTMLCell(80, 10, 25, 126, '<span style="color: #666666; font-size: 13px; font-weight: 500;">Paypal</span>');
    $obj_pdf->writeHTMLCell(180, 10, 20, 124, '<div style="background-color: #fff; text-align: left;"></div>');
    $obj_pdf->writeHTMLCell(180, 10, 20, 126, '<div style="background-color: #fff; text-align: left;"></div>');
    $obj_pdf->writeHTMLCell(180, 10, 20, 130, '<div style="background-color: #fff; border-bottom: 1.5px solid #999999; text-align: left;"></div>');
    //Pagamento 

   if($row3['estadia_conc']==1){ 
       
    $obj_pdf->writeHTMLCell(80, 10, 25, 147, '<span style="color: #ffffff; font-size: 15px; font-weight: 550;">Pagamento</span>');
    $obj_pdf->writeHTMLCell(80, 10, 175, 147, '<span style="color: #ffffff; font-size: 15px; font-weight: 550;">Preço/€</span>');
    $obj_pdf->writeHTMLCell(180, 10, 20, 145, '<div style="background-color: #c1c9b6; text-align: left;"></div>');
    $obj_pdf->writeHTMLCell(180, 10, 20, 146, '<div style="background-color: #c1c9b6; text-align: left;"></div>');
    $obj_pdf->writeHTMLCell(180, 10, 20, 151, '<div style="background-color: #c1c9b6; border-bottom: 1.5px solid #6f7d5d; text-align: left;"></div>');

    $obj_pdf->writeHTMLCell(80, 10, 25, 161, '<span style="color: #666666; font-size: 13px; font-weight: 500;">Taxa Paypal</span>');
    $obj_pdf->writeHTMLCell(80, 10, 118, 161, '<span style="color: #666666; font-size: 13px; font-weight: 500; text-align:right;">'.$fee.' €</span>');
    $obj_pdf->writeHTMLCell(180, 10, 20, 159, '<div style="background-color: #fff; text-align: left;"></div>');
    $obj_pdf->writeHTMLCell(180, 10, 20, 161, '<div style="background-color: #fff; text-align: left;"></div>');
    $obj_pdf->writeHTMLCell(180, 10, 20, 165, '<div style="background-color: #fff; border-bottom: 1.5px solid #999999; text-align: left;"></div>');

    $obj_pdf->writeHTMLCell(80, 10, 25, 176, '<span style="color: #666666; font-size: 13px; font-weight: 500;">Pagamento</span>');
    $obj_pdf->writeHTMLCell(80, 10, 118, 176, '<span style="color: #666666; font-size: 13px; font-weight: 500; text-align:right;">'.$preco.' €</span>');
    $obj_pdf->writeHTMLCell(180, 10, 20, 173, '<div style="background-color: #fff; text-align: left;"></div>');
    $obj_pdf->writeHTMLCell(180, 10, 20, 176, '<div style="background-color: #fff; text-align: left;"></div>');
    $obj_pdf->writeHTMLCell(180, 10, 20, 179, '<div style="background-color: #fff; border-bottom: 1.5px solid #999999; text-align: left;"></div>');

   } else {

    $obj_pdf->writeHTMLCell(80, 10, 25, 147, '<span style="color: #ffffff; font-size: 15px; font-weight: 550;">Pagamento</span>');
    $obj_pdf->writeHTMLCell(80, 10, 175, 147, '<span style="color: #ffffff; font-size: 15px; font-weight: 550;">Preço/€</span>');
    $obj_pdf->writeHTMLCell(180, 10, 20, 145, '<div style="background-color: #c1c9b6; text-align: left;"></div>');
    $obj_pdf->writeHTMLCell(180, 10, 20, 146, '<div style="background-color: #c1c9b6; text-align: left;"></div>');
    $obj_pdf->writeHTMLCell(180, 10, 20, 151, '<div style="background-color: #c1c9b6; border-bottom: 1.5px solid #6f7d5d; text-align: left;"></div>');

    $obj_pdf->writeHTMLCell(80, 10, 25, 161, '<span style="color: #666666; font-size: 13px; font-weight: 500;">Taxa Paypal</span>');
    $obj_pdf->writeHTMLCell(80, 10, 118, 161, '<span style="color: #666666; font-size: 13px; font-weight: 500; text-align:right;">0 €</span>');
    $obj_pdf->writeHTMLCell(180, 10, 20, 159, '<div style="background-color: #fff; text-align: left;"></div>');
    $obj_pdf->writeHTMLCell(180, 10, 20, 161, '<div style="background-color: #fff; text-align: left;"></div>');
    $obj_pdf->writeHTMLCell(180, 10, 20, 165, '<div style="background-color: #fff; border-bottom: 1.5px solid #999999; text-align: left;"></div>');

    $obj_pdf->writeHTMLCell(80, 10, 25, 176, '<span style="color: #666666; font-size: 13px; font-weight: 500;">Reembolsado</span>');
    $obj_pdf->writeHTMLCell(80, 10, 118, 176, '<span style="color: #666666; font-size: 13px; font-weight: 500; text-align:right;">'.$preco.' €</span>');
    $obj_pdf->writeHTMLCell(180, 10, 20, 173, '<div style="background-color: #fff; text-align: left;"></div>');
    $obj_pdf->writeHTMLCell(180, 10, 20, 176, '<div style="background-color: #fff; text-align: left;"></div>');
    $obj_pdf->writeHTMLCell(180, 10, 20, 179, '<div style="background-color: #fff; border-bottom: 1.5px solid #999999; text-align: left;"></div>');

   }

    //Total
    if($row3['estadia_conc']==1){
    $obj_pdf->writeHTMLCell(80, 10, 118, 188, '<span style="color: #666666; font-size: 13px; font-weight: 500; text-align:right;"><b>Total: '.$preco_total.' €</b></span>');
    } else {
        $obj_pdf->writeHTMLCell(80, 10, 118, 188, '<span style="color: #666666; font-size: 13px; font-weight: 500; text-align:right;"><b>Total: '.$preco.' €</b></span>'); 
    }
    $obj_pdf->Output($data_pag.'.pdf', 'I');  
    } 
}  
?>