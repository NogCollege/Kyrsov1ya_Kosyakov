// JavaScript код для отправки данных формы на сервер
$(document).ready(function() {
    $('#order-form').on('beforeSubmit', function(e) {
        var form = $(this);
        var formData = form.serialize();

        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: formData,
            success: function(response) {
                // Выводим сообщение о успешном оформлении заказа
                alert('Заказ успешно оформлен!');
                // Очищаем поля формы
                form[0].reset();
            },
            error: function(xhr) {
                // Выводим сообщение об ошибке
                alert('Произошла ошибка при оформлении заказа!');
            }
        });

        return false;
    });
});
