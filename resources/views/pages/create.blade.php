@extends('layout.baseLayout')

@push('create-form')
<style>
.create-form {
    overflow: auto;
}

.create-form > *:not(:first-child) {
   margin-top: 20px;
}

.ingradiants, .trial-form {
    border: 1px solid gray;
    border-radius: 5px;
    width: 100%;
    padding: 10px 20px;
}

.ingradiants {
    display: flex;
    flex-wrap: wrap;
    justify-content: start;
    gap: 20px;
}

.ingradiants > * {
    cursor: pointer;
}

</style>
@endpush

@section('content')
   <div class="create-form">
       <h2>Create New Form</h2>

       @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <p class="error-msg">{{$errors->first()}}</p>
        </div>
        @endif

       <form action="{{ url('store') }}" method="post">
       @csrf
       <div class="mb-3 label">
            <label for="input-label" class="form-label">Form Name</label>
            <input type="text" class="form-control" id="form-name" name="form_name" placeholder="Form Name">
        </div>
        <fieldset class="ingradiants">
           <legend>Ingradiants</legend>
            <!-- <button type="button" class="create-element btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Text
           </button> -->
            <button type="button" class="create-element btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Short answer
           </button>
            <button type="button" class="create-element btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Long answer
           </button>
            <button type="button" class="create-element btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Checkbox
           </button>
            <button type="button" class="create-element btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Radio
           </button>
            <!-- <button type="button" class="create-element btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Multiple choice
           </button> -->
            <button type="button" class="create-element btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Dropdown
           </button>
            <button type="button" class="create-element btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Time and Date
           </button>
        </fieldset>

        <fieldset class="trial-form mt-4">
           <legend>Trial</legend>
           
           <div id="append-ele" class="append-ele"></div>
           <input type="hidden" class="append-in-input" name="form_body">
           <input type="hidden" class="append-validation" name="validation_rules">

        </fieldset>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Customize <span id="modalLabelSeg"></span></h5>
                    <button type="button" class="btn-close on-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 radio-group-name">
                       <label for="radio-group" class="form-label">Radio Group Name</label>
                       <input type="text" class="form-control radio-group" id="radio-group" placeholder="name@example.com">
                    </div>
                    <div class="mb-3 label">
                       <label for="input-label" class="form-label">Label</label>
                       <input type="text" class="form-control" id="input-label" placeholder="name@example.com">
                    </div>
                    <div class="mb-3 placeholder">
                       <label for="input-placeholder" class="form-label">Placeholder</label>
                       <input type="text" class="form-control" id="input-placeholder" placeholder="name@example.com">
                    </div>
                    <div class="mb-3 options">
                       <label for="multi-options" class="form-label">Multi options&nbsp;&nbsp;<button class="btn btn-danger btn-sm add-op-ele float-right" type="button" disabled>+</button></label>
                       <div id="append-options"></div>
                    </div>
                    <div class="mb-3 is-required">
                        <div class="form-check">
                            <input class="form-check-input validation" name="validation" type="checkbox" value="required" id="is-required">
                            <label class="form-check-label" for="is-required">
                                Required
                            </label>
                        </div>
                    </div>
                    <div class="mb-3 is-required">
                        <div class="form-check">
                            <input class="form-check-input validation" name="validation" type="checkbox" value="email" id="is-required">
                            <label class="form-check-label" for="is-required">
                                Email Validation
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary on-close" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="generate btn btn-primary" data-bs-dismiss="modal">Save changes</button>
                </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-danger mt-4 float-right">Create</button>
        </form>
    </div>

   <script>
   $(document).ready(function(){ 
        $('.summernote').summernote();

        var btn = ''
        var inputEl = ''
        var btnVal = ''
        var generateGroupName = ''
        var validation = {}

        $('.add-op-ele').click(function(){ 
            var grpName = $('#radio-group').val()
            var grpTexts = grpName.split(' ')
            generateGroupName = grpTexts.join('-').toLowerCase()
            var opEle = '<div class="radio row gap-2 px-3 mb-3 label"><input type="text" name="'+generateGroupName+'[]" class="radio-options col-md-10 form-control" id="radio-options" placeholder="Choice"><button class="col-md-1 btn btn-danger btn-sm remove-radio float-right">-</button></div>'

            $("#append-options").append(opEle);
        })

        function reset() {
            
        }


      $('.create-element').click(function(e){ 
        

            $('.radio-group').val('')
            $('#input-label').val('')
            $('#input-placeholder').val('')
            $('.validation').val('')
            $("#append-options").empty()


        var btn = e.target
        var btnVal = $.trim($(btn).text())
        
        $('#modalLabelSeg').text(btnVal)

        if(btnVal == 'Radio' || btnVal == 'Checkbox' || btnVal == 'Dropdown') {
            $('.placeholder').hide()
        } else {
            $('.radio-group-name').hide()
        }

        if(btnVal == 'Time and Date') {
            $('.placeholder').hide()
            $('.radio-group-name').hide()
        }

        if(btnVal != 'Radio' && btnVal != 'Checkbox' && btnVal != 'Dropdown') {
            $('.options').hide()
        }
        
        $('.generate').click(function(e){ 
            var inLbl = $('#input-label').val()
            var inPlaceholder = $('#input-placeholder').val()
            var isRequired = $('#is-required').val()
            var radioOptions = $("input[name^="+generateGroupName+"]")

            var lblTexts = inLbl.split(' ')
            var generateId = lblTexts.join('-').toLowerCase()
            
            if(btnVal == 'Short answer') {
                // Validation Rules 
                var validations = $('input[name="validation"]:checked').serialize()
                var segments = validations.split('&')
                var rule = segments.map(function(object) {
                    return object.replace('validation=','');
                })
                var rules = rule.join('|')
                validation[generateId] = rules
                // setRules.push(validation)

                // Validation Rule ends
                inputEl = '<div class="ele mb-3"><label for="exampleFormControlInput1" class="form-label">'+inLbl+'&nbsp;&nbsp;<button class="btn btn-danger btn-sm remove-ele float-right">X</button></label><input type="'+btnVal+'" class="form-control" id="'+generateId+'" name="'+generateId+'" placeholder="'+inPlaceholder+'"></div>'
            } else if(btnVal == 'Long answer') {
                // Validation Rules 
                var validations = $('input[name="validation"]:checked').serialize()
                var segments = validations.split('&')
                var rule = segments.map(function(object) {
                    return object.replace('validation=','');
                })
                var rules = rule.join('|')
                validation[generateId] = rules
                // setRules.push(validation)

                // Validation Rule ends
                inputEl = '<div class="ele mb-3"><label for="exampleFormControlInput1" class="form-label">'+inLbl+'&nbsp;&nbsp;<button class="btn btn-danger btn-sm remove-ele float-right">X</button></label><div><textarea class="form-control" id="'+generateId+'" name="'+generateId+'"></textarea></div></div>'
            } else if(btnVal == 'Radio') {
                // Validation Rules 
                var validations = $('input[name="validation"]:checked').serialize()
                var segments = validations.split('&')
                var rule = segments.map(function(object) {
                    return object.replace('validation=','');
                })
                var rules = rule.join('|')
                validation[generateGroupName] = rules

                // Validation Rule ends
                var options = []

                console.log(radioOptions)

                var titles = $(radioOptions).map(function(idx, elem) {
                    return $(elem).val();
                }).get();
                
                for (i = 0; i < titles.length; i++){
                    options.push('<div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="'+generateGroupName+'" value="'+titles[i]+'" id="flexRadioDefault2" checked><label class="form-check-label" for="flexRadioDefault2">'+titles[i]+'</label></div>');
                }
                inputEl =  '<div class="ele mb-3"><label for="exampleFormControlInput1" class="form-label">'+inLbl+'&nbsp; &nbsp;<button class="btn btn-danger btn-sm remove-ele float-right">X</button></label><div>'+options+'</div></div>'
            } else if(btnVal == 'Checkbox') {
                // Validation Rules 
                var validations = $('input[name="validation"]:checked').serialize()
                var segments = validations.split('&')
                var rule = segments.map(function(object) {
                    return object.replace('validation=','');
                })
                var rules = rule.join('|')
                validation[generateGroupName] = rules

                // Validation Rule ends
                var options = []

                console.log(radioOptions)

                var titles = $(radioOptions).map(function(idx, elem) {
                    return $(elem).val();
                }).get();
                
                for (i = 0; i < titles.length; i++){
                    options.push('<div class="form-check"><input class="form-check-input" type="checkbox" value="" name="'+generateGroupName+'['+titles[i]+']" id="flexCheckDefault"><label class="form-check-label" for="flexCheckDefault">'+titles[i]+'</label></div>');
                }

                inputEl = '<div class="ele mb-3"><label for="exampleFormControlInput1" class="form-label">'+inLbl+'&nbsp; &nbsp;<button class="btn btn-danger btn-sm remove-ele float-right">X</button></label><div>'+options+'</div></div>'
            } else if(btnVal == 'Dropdown') {
                // Validation Rules 
                var validations = $('input[name="validation"]:checked').serialize()
                var segments = validations.split('&')
                var rule = segments.map(function(object) {
                    return object.replace('validation=','');
                })
                var rules = rule.join('|')
                validation[generateId] = rules

                // Validation Rule ends
                var options = []

                console.log(radioOptions)

                var titles = $(radioOptions).map(function(idx, elem) {
                    return $(elem).val();
                }).get();
                
                for (i = 0; i < titles.length; i++){
                    options.push('<option value="'+titles[i]+'">'+titles[i]+'</option>');
                }
                
                inputEl = '<div class="ele mb-3"><label for="exampleFormControlInput1" class="form-label">'+inLbl+'&nbsp;&nbsp;<button class="btn btn-danger btn-sm remove-ele float-right">X</button></label><select class="form-select" id="'+generateId+'" name="'+generateId+'" aria-label="Default select example">'+options+'</select></div>'
            } else if(btnVal == 'Time and Date') {
                // Validation Rules 
                var validations = $('input[name="validation"]:checked').serialize()
                var segments = validations.split('&')
                var rule = segments.map(function(object) {
                    return object.replace('validation=','');
                })
                var rules = rule.join('|')
                validation[generateId] = rules

                // Validation Rule ends
                inputEl = '<div class="ele mb-3"><label for="exampleFormControlInput1" class="form-label">'+inLbl+'&nbsp;&nbsp;<button class="btn btn-danger btn-sm remove-ele float-right">X</button></label><input type="date" class="form-control" name="'+generateId+'" id="'+generateId+'"></div>'
            }
            
            $(".append-ele").append(inputEl);
            var getAllData = $('.append-ele').html()
            $('.append-in-input').val(getAllData)
            $('.append-validation').val(JSON.stringify(validation))

            $('.placeholder').show()
            $('.options').show()
            $('.radio-group-name').show()

            btnVal = ''
            inLbl = ''
            inPlaceholder = ''
            errMsg = ''
            inputEl = ''
            radioOptions = []
        }); 

        $('.on-close').click(function(e){ 
            $('.placeholder').show()
            $('.options').show()
            $('.radio-group-name').show()
            btnVal = ''
            inLbl = ''
            inPlaceholder = ''
            errMsg = ''
            inputEl = ''
            radioOptions = []
        }); 
    });

    $(document).on('click', function(e) {
        if ( e.target.id != 'radio-group' ) {
            if($('#radio-group').val().length > 2) {
                $('.add-op-ele').removeAttr('disabled')
            } else {
                $('.add-op-ele').attr('disabled', 'disabled')
            }
        }
    });

    $(document).on('click', '.remove-ele', function(){  
         $(this).parents('.ele').remove();
    });

    $(document).on('click', '.remove-radio', function(){  
         $(this).parents('.radio').remove();
    });

    $(function() {
        $("#append-ele").sortable();
        var getAllData = $('.append-ele').html()
        $('.append-in-input').val(getAllData)
    });

   })
    </script>
@endsection