// Call Jquery & Bootstrap
var $ = require('jquery');
require('bootstrap-sass');

// Auto-Completion Specimen
$(document).ready(function () {
    $("#appbundle_specimen_input").keyup(function () {
        let input = $(this).val();


        if ( input.length >= 2)  {

            $.ajax({
                type: "POST",
                url: "/specimen/new/list/" + input,
                dataType: "json",
                timeout: 3000,

                success: function (response) {
                    let genusSpecies = JSON.parse(response.data);

                    let html = "";
                    if (genusSpecies) {
                        $('.dropdown-specimen-result').show();

                    }
                    for (genusSpecie of genusSpecies) {
                        html += `<li class="genusSpecie_item" data-id='${genusSpecie.id}'>${genusSpecie.genus} ${genusSpecie.species}</li>`;
                    }


                    let autocompleteSpecimen = $("#autocomplete-specimen");
                    autocompleteSpecimen.html(html);
                    $('li.genusSpecie_item').on("click",function () {
                        $("#appbundle_specimen_input").val($(this).text());
                        $("#appbundle_specimen_specie").val($(this).data('id'));
                        $("#autocomplete-specimen").html("");
                        $("#form_specie").submit();
                        $(".dropdown-specimen-result").hide();

                    });
                },
                error: function () {
                    $("#autocomplete-specimen").text("Ajax call error");
                }
            });
        } else {
            $("#autocomplete-specimen").html("");
        }

    });
});