function renderForm() {
    $('a').remove();
    $('body').append('<form>' +
        '<input type="text" name="code" class="form-control" aria-label="Код подтверждения">' +
        '<button type="submit">Отправить</button>' +
        '</form>');
}