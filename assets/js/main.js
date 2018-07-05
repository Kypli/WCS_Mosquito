// Call Jquery & Bootstrap
var $ = require('jquery');
require('bootstrap-sass');

// Checkbox RedToGreen
$(document).ready(function(){

    $("input:checked").parent().addClass('backgroundTrue');

    $("input").on('click', function(e){
        e.stopPropagation();
        if (this.checked) {
            $(this).parent().addClass('backgroundTrue');
        } else {
            $(this).parent().removeClass('backgroundTrue');
        }
    });
});

// Confirm delete
$(".delete").on("click", function() {
    if (confirm('Do you confirm to delete it ?')) {
        return true;
    } else {
        return false;
    }
});

// Auto-Completion
$(document).ready(function () {
    $("#appbundle_search_search").keyup(function () {
        let input = $(this).val();

        if ( input.length >= 2)  {

            $.ajax({
                type: "GET",
                url: "/specimen/list/" + input,
                dataType: "json",
                timeout: 3000,
                success: function (response) {
                    let data = JSON.parse(response.data);
                    let html = "";
                    if (data) {
                        $('.open').show();
                    }

                    Object.keys(data).forEach(function (dataCategory) {
                        if (data[dataCategory].length){
                            html += `<li class="category_ajax_name"> ${dataCategory}</li>`;
                            for (category of data[dataCategory]) {
                                html += `<li class="category_item">${category.name}</li>`;
                            }
                        }
                    });

                    let autocomplete = $("#autocomplete");
                    autocomplete.html(html);
                    $('li.category_item').on("click",function () {
                        $("#appbundle_search_search").val($(this).text());
                        $("#autocomplete").html("");
                        $("#form_search").submit();
                        $(".open").hide();

                    });
                },
                error: function () {
                    $("#autocomplete").text("Ajax call error");
                }
            });
        } else {
            $("#autocomplete").html("");
        }

    });
});