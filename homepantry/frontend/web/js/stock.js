function alterarStock(id, tipo) {
    let url = tipo === 'inc' ? STOCK_INC_URL : STOCK_DEC_URL;
    let csrf = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: {
            id: id,
            _csrf: csrf
        },
        success: function (res) {
            if (res.success) {
                $('#qtd-' + id).text(res.quantidade);
                $('#preco-' + id).text(res.preco.toFixed(2) + ' €');
            } else {
                console.warn('Resposta sem sucesso', res);
            }
        },
        error: function (xhr) {
            console.error('Erro AJAX:', xhr.responseText);
        }
    });
}
