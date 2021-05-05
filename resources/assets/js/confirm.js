(function () {
    console.log('ok');
    $(".delete").on("click", function() {
        return confirm("Do you want to delete this item ?");
    });
})($)