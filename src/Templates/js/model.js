$('#¤-model¤-table').on('click', '.¤-model¤-delete', function(){
    var row = $(this).parentsUntil('tr').parent();
    var id = $(this).data('id');
    $('#¤-model¤-question').data('row', row);
    $('#¤-model¤-question').data('id', id);
});
$('.¤-model¤-delete-modal #modalSubmit').on('click', function(){
    var id = $('#¤-model¤-question').data('id');
    var row = $('#¤-model¤-question').data('row');
    axios.delete(route('¤_model¤.delete', {¤_model¤_id:id}))
        .then(function (response) {
            notify(response.data.status);
            row.addClass('overflow-hidden').animate({
                opacity: 0,
                height: 0
              }, 300, function() {
                $(this).remove();
              });
        })
        .catch(function (error) {
            console.log(error);
        });
});