function imprimirTrechoHtml() {
    // Oculta o botão de impressão
    document.querySelector(".panel-footer .btn-info").style.display = "none";

    // Cria uma nova janela temporária para impressão
    var janelaImprimir = window.open('', '_blank');
    janelaImprimir.document.write('<html><head><title>Imprimir</title>');
    janelaImprimir.document.write('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">');
    janelaImprimir.document.write('<style>@media print{.no-print, .no-print *{display:none!important}}</style>');
    janelaImprimir.document.write('</head><body>');
    janelaImprimir.document.write('<div id="printableArea">');
    janelaImprimir.document.write(document.getElementById("printableArea").innerHTML);
    janelaImprimir.document.write('</div>');
    janelaImprimir.document.write('</body></html>');
    janelaImprimir.document.close();

    // Espera até que o conteúdo seja carregado na janela temporária
    janelaImprimir.onload = function () {
        // Chama a função de impressão do navegador na janela temporária
        janelaImprimir.print();
        janelaImprimir.close();

        // Restaura o estado original após a impressão
        document.querySelector(".panel-footer .btn-info").style.display = "inline-block";
    };
}




