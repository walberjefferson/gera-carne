function mascaras() {
    $('.data').mask("00/00/0000", {placeholder: "__/__/____"});
    $('.valor').mask("#.##0,00", {reverse: true, placeholder: "0,00"});
}

$(function () {
    mascaras();
    $(document).on('click', '.add_parcela', function () {
        $("#parcelas").append(parcela());
        mascaras();
    });

    $(document).on('click', '.remove_parcela', function (e) {
        e.preventDefault();
        console.log($(this).parent().parent().remove());
    });
});

function parcela() {
    var parcela_html = '<div class="form-row">' +
        '<div class="form-group col-2">' +
        '<input type="text" class="form-control data" id="vencimento" name="vencimento[]" required placeholder="Vencimento">' +
        '</div>' +
        '<div class="form-group col-2">' +
        '<input type="text" class="form-control valor" id="valor" name="valor[]" required placeholder="Valor Parcela">' +
        '</div>' +
        '<div class="form-group col-1">' +
        '<a href="#" class="btn btn-danger btn-block remove_parcela"><i class="fa fa-trash-o"></i></a>' +
        '</div>' +
        '</div>';
    return parcela_html;
}
