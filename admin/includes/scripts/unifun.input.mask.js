if (!String.prototype.startsWith) {
    String.prototype.startsWith = function(searchString, position) {
        position = position || 0;
        return this.indexOf(searchString, position) === position;
    };
}

$.fn.inputMask = function (options) {
    var Object = $(this);
    Object.focus();
    if (typeof options === 'undefined') {
        console.log("Provide options");
    } else {
        var defaultValue = Object.val();
        var mask = options.mask.match(/\d+/)[0];
        var defaultValueSet = options.mask;
        var maskLength = options.mask.length;
        var color = {color: "#7A7A7A"}
        var currentCaretPosition = 0;
        selectUnselect(Object, maskLength);

        if(defaultValue.substr(0, mask.length) === mask){
            defaultValueSet += defaultValue.substr(mask.length, defaultValue.length);
        }else{
            defaultValueSet += defaultValue;
        }

        defaultValueSet = defaultValueSet.substr(0, maskLength+options.numbers);
        Object.val(defaultValueSet);
        Object.css(color);
        var newValue = Object.val();
        var currentPosition = Object.val().match(/[\d-]+/)[0].length;
        if(newValue.length > maskLength) {
            for ($i = 0; $i < (maskLength + options.numbers) - currentPosition; $i++) {
                newValue += '_';
            }
            Object.val(newValue);

            setCaretPosition(Object.attr('id'), currentPosition);
        }

        var inputsArray = [96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 46, 8, 35, 36, 37, 38, 39, 40];
        var numberArray = [96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57];

        Object.on("paste", function (e) {
            e.preventDefault();
            var pastedData = e.originalEvent.clipboardData.getData('text').match(/\d/g).join("");
            var selectStart = $(this)[0].selectionStart;
            var selectEnd = $(this)[0].selectionEnd;
            var text = $(this).val().match(/[\d-]/g).join("").trim();

            if (selectStart == selectEnd && selectStart >= maskLength || selectStart == 0) {
                if (pastedData.startsWith(options.mask.match(/\d/g).join(""))) {
                    pastedData = pastedData.substr(mask.length);
                }
            }

            if (selectStart != selectEnd) {
                var data1 = text.substr(0, selectStart);
                var data2 = text.substr(selectEnd, text.length);

                text = data1 + data2;
                selectStart = data1.length;
                var text = [text.slice(0, selectStart), pastedData, text.slice(selectStart)].join('');
            } else {
                var text = [text.slice(0, selectStart), pastedData, text.slice(selectStart)].join('');
            }

            if(selectStart == 0)
                text = options.mask + text;

            if (text.length > options.numbers + maskLength)
                text = text.substr(0, options.numbers + maskLength);

            Object.val(text);

            var CurrentValue = $(this).val();
            var newValue = CurrentValue;
            var currentPosition = $(this).val().match(/[\d-]+/)[0].length;
            if(newValue.length > maskLength) {
                for ($i = 0; $i < (maskLength + options.numbers) - currentPosition; $i++) {
                    newValue += '_';
                }
                Object.val(newValue);

                setCaretPosition($(this).attr('id'), currentPosition);
            }
        });

        Object.on("keydown", function (e) {
            var event = e.which;
            var valueLength = $(this).val().length;
            var CurrentValue = $(this).val();
            currentCaretPosition = $(this)[0].selectionStart;
            selectUnselect(Object, maskLength);

            if(event != 13) {
                if (
                    !(
                        (event == 86 && e.ctrlKey) ||
                        (event == 67 && e.ctrlKey) ||
                        (event == 82 && e.ctrlKey) ||
                        (event == 116 && e.ctrlKey) ||
                        (event == 65 && e.ctrlKey)
                    )
                ) {
                    if ($(this)[0].selectionStart < maskLength && (event == 8 || event == 46))
                        e.preventDefault();

                    if (CurrentValue.match(/[\d-]+/)[0].length <= maskLength && (event == 8 || event == 46))
                        e.preventDefault();

                    if (inputsArray.indexOf(event) == -1)
                        e.preventDefault();
                    else {
                        var currentPosition = CurrentValue.match(/[\d-]+/)[0].length;
                        if (numberArray.indexOf(event) > -1 && valueLength <= (options.numbers + maskLength)) {
                            Object.val(CurrentValue.substr(0, CurrentValue.length - 1));
                            setCaretPosition($(this).attr('id'), currentPosition);
                        }
                    }
                }

                var currentPosition = CurrentValue.length;
                var newValue = CurrentValue;
                if (event != 46 && event != 8 && currentPosition == maskLength) {
                    for ($i = 1; $i < (maskLength + options.numbers) - currentPosition; $i++) {
                        newValue += '_';
                    }
                    Object.val(newValue);

                    setCaretPosition($(this).attr('id'), currentPosition);
                }
            }
        });

        Object.on("keyup", function (e) {
            var event = e.which;
            var CurrentValue = $(this).val();
            var currentPosition = CurrentValue.length;
            var totalLength = CurrentValue.match(/[\d-]+/)[0].length;

            if(CurrentValue.match(/[\d-]+/)[0].length == maskLength){
                Object.val(options.mask);
            }else if ((event == 46 || event == 8) && CurrentValue.match(/[\d-]+/)[0].length > maskLength && totalLength <= (options.numbers + maskLength )) {
                if($(this)[0].selectionStart > 0) {
                    Object.val(CurrentValue + '_');
                    if (event == 8)
                        currentCaretPosition--;
                    setCaretPosition($(this).attr("id"), currentCaretPosition);
                }
            }
        });

        Object.on("focus", function () {
            color.color = "#333333";
            $(this).css(color);

            var CurrentValue = $(this).val();
            var newValue = CurrentValue;
            var currentPosition = $(this).val().match(/[\d-]+/)[0].length;
            if(newValue.length > maskLength) {
                for ($i = 0; $i < (maskLength + options.numbers) - currentPosition; $i++) {
                    newValue += '_';
                }
                Object.val(newValue);

                setCaretPosition($(this).attr('id'), currentPosition);
            }
            setCaretPosition($(this).attr('id'), currentPosition);
        });

        Object.on("click", function(){
            var currentPosition = $(this).val().match(/[\d-]+/)[0].length;
            if($(this)[0].selectionStart > currentPosition || $(this)[0].selectionStart < maskLength)
                setCaretPosition($(this).attr('id'), currentPosition);
        });

        Object.on("blur", function () {
            var valueLength = $(this).val().length;

            if (valueLength > maskLength) {
                color.color = "#333";
            } else {
                color.color = "#7A7A7A";
            }

            $(this).css(color);
            var CurrentValue = $(this).val();
            Object.val(CurrentValue.match(/[\d-]+/)[0]);
        });
    }

    function setCaretPosition(elemId, caretPos) {
        var el = document.getElementById(elemId);

        el.value = el.value;
        // ^ this is used to not only get "focus", but
        // to make sure we don't have it everything -selected-
        // (it causes an issue in chrome, and having it doesn't hurt any other browser)

        if (el !== null) {

            if (el.createTextRange) {
                var range = el.createTextRange();
                range.move('character', caretPos);
                range.select();
                return true;
            }

            else {
                // (el.selectionStart === 0 added for Firefox bug)
                if (el.selectionStart || el.selectionStart === 0) {
                    el.focus();
                    el.setSelectionRange(caretPos, caretPos);
                    return true;
                }

                else { // fail city, fortunately this never happens (as far as I've tested) :)
                    el.focus();
                    return false;
                }
            }
        }
    }

    function selectUnselect(Object, maskLength){
        if (Object.val().length <= maskLength){
            Object.attr('unselectable', 'on').css('user-select', 'none').on('selectstart', false);
        }else{
            Object.removeAttr("unselectable");
            Object.css("user-select", "")
        }
    }

    function getSelectionText() {
        var text = "";
        if (window.getSelection) {
            text = window.getSelection().toString();
        } else if (document.selection && document.selection.type != "Control") {
            text = document.selection.createRange().text;
        }
        return text;
    }
}