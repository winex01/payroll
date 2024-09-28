crud.field('civilStatus').onChange(function(field) {
    if (field.value == 1) {
        crud.field('date_of_marriage').hide();
    } else {
        crud.field('date_of_marriage').show();
    }
 }).change();
