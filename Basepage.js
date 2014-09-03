var EmptyGuid = '00000000-0000-0000-0000-000000000000';

if (typeof (browser) != 'undefined') {
    if (browser == "ie" || browser == "mozilla") {
        objDoc = document.documentElement;
    }
    else if (browser == "safari") {
        objDoc = document.body;
    }
}

function findAndReplaceURL(url) {
    var urlToReturn = url;
    var protocol = window.location.protocol;
    if (url.toLowerCase().indexOf(document.domain.toLowerCase()) > 0) {
        urlToReturn = url;
    }
    else if (url.toLowerCase().indexOf("http://") > -1 || url.toLowerCase().indexOf("https://") > -1) {
        urlToReturn = url;
    }
    else {
        var port = window.location.port != "" ? ":" + window.location.port : "";
        if ((protocol.toLowerCase() == "http:" && (port != 80 && port != "")) || (protocol.toLowerCase() == "https:" && port != 443))
            urlToReturn = protocol + '//' + document.domain + port + url;
        else
            urlToReturn = protocol + '//' + document.domain + url;
    }
    return urlToReturn;
}

function showLink(url, windowstate, features) {
    url = unescape(findAndReplaceURL(url));
    if (windowstate == "_blank") {
        window.open(url, windowstate);
    }
    else if (windowstate == "_blankPopUp") {
        windowstate == "_blank"
        window.open(url, windowstate, features);
    }
    else {
        window.open(url, windowstate, features);
    }
}

function Trim(s) {
    // Remove leading spaces and carriage returns
    if (s != null || s == "") {
        while ((s.substring(0, 1) == ' ') || (s.substring(0, 1) == '\n') || (s.substring(0, 1) == '\r')) {
            s = s.substring(1, s.length);
        }
        // Remove trailing spaces and carriage returns
        while ((s.substring(s.length - 1, s.length) == ' ') || (s.substring(s.length - 1, s.length) == '\n') || (s.substring(s.length - 1, s.length) == '\r')) {
            s = s.substring(0, s.length - 1);
        }
        return s;
    }
}
if (typeof scrollAdjust == 'function') {
    //calling the function to adjust the position of the toolbar on scrolling
    setInterval('scrollAdjust()', 10);
}

function MM_preloadImages() {
    var d = document; if (d.images) {
        if (!d.MM_p) d.MM_p = new Array(); 
        var i, j = d.MM_p.length, a = MM_preloadImages.arguments;
        for (i = 0; i < a.length; i++) 
            if (a[i].indexOf('#') != 0) { d.MM_p[j] = new Image; d.MM_p[j++].src = a[i]; } 
    } 
}

function MM_swapImgRestore() {
    var i, x, a = document.MM_sr;
    for (i = 0; a && i < a.length && (x = a[i]) && x.oSrc; i++)
        x.src = x.oSrc;
}

function MM_findObj(n, d) {
    var p, i, x;
    if (!d) d = document;
    if ((p = n.indexOf('?')) > 0 && parent.frames.length) {
        d = parent.frames[n.substring(p + 1)].document; n = n.substring(0, p);
    }
    if (!(x = d[n]) && d.all) x = d.all[n];
    for (i = 0; !x && i < d.forms.length; i++)
        x = d.forms[i][n];
    for (i = 0; !x && d.layers && i < d.layers.length; i++)
        x = MM_findObj(n, d.layers[i].document);
    if (!x && d.getElementById) x = d.getElementById(n);
    return x;
}

function MM_swapImage() {
    var i, j = 0, x, a = MM_swapImage.arguments;
    document.MM_sr = new Array;
    for (i = 0; i < (a.length - 2); i += 3)
        if ((x = MM_findObj(a[i])) != null) {
            document.MM_sr[j++] = x;
            if (!x.oSrc) x.oSrc = x.src;
            x.src = a[i + 2];
        }
}

function stringformat(str)            //created by Adams to format the string for localization needs
{
    if (arguments.length == 0)
        return null;

    var str = arguments[0];
    for (var i = 1; i < arguments.length; i++) {
        var re = new RegExp('\\{' + (i - 1) + '\\}', 'gm');
        str = str.replace(re, arguments[i]);
    }
    return (str);
}

var Data;
function ProcessFormData(callBackId, doValidation, id, mode, clientId) {
    abortFormRequest = false;

    if (Data) {
        alert(clRsMessage["PleaseSaveBeforeFormSubmit"]);
        return false;
    }
    else {
        var returnValue = true;

        formProperties = eval(id + "_properties");
        formJSMessages = eval(id + "_jsMessages");
        formMode = mode;
        if (formMode == "1")
            fieldProperties = eval(id + "_Fields");

        controlIds = formProperties.ControlIds;

        if (doValidation && typeof Validate_Form == 'function')
            returnValue = Validate_Form(controlIds, id, clientId);

        if (typeof Custom_Validate_Form == 'function')
            returnValue = Custom_Validate_Form(returnValue, controlIds, fieldProperties, id, clientId);

        if (returnValue) {
            var xml = "";

            var controls = controlIds.split(',');
            for (var i = 0; i < controls.length; i++) {
                var control = document.getElementById(controls[i]);
                if (control && GetAttribute(control, "includeInResults").toLowerCase() == "true") {
                    var value = "";
                    var label = "";
                    switch (GetAttribute(control, "objectType").toLowerCase()) {
                        case "textbox":
                        case "password":
                            value = control.value;
                            break;
                        case "hiddenfield":
                            if (GetAttribute(control, "specialValue") == "None" || GetAttribute(control, "specialValue") == "")
                                value = GetAttribute(control, "textValue");
                            else
                                value = "@" + GetAttribute(control, "specialValue") + "@";
                            break;
                        case "fileupload":
                            value = control.getAttribute("selectedFile");
                            break;
                        case "datepicker":
                            dateControl = document.getElementById(controls[i] + "_txt");
                            var dateFormat = GetAttribute(control, "customFormat");
                            if (dateFormat == "" || dateFormat == "undefined")
                                dateFormat = GetAttribute(control, "format");
                            value = dateControl.value + "^" + dateFormat;
                            break;
                        case "dropdown":
                            value = control[control.selectedIndex].value;
                            break;
                        case "textarea":
                            value = control.value;
                            break;
                        case "radiobutton":
                        case "checkbox":
                            value = "";
                            listItems = control.getElementsByTagName("INPUT");
                            for (var j = 0; j < listItems.length; j++) {
                                if (listItems[j].checked) {
                                    if (value == "")
                                        value = listItems[j].value;
                                    else
                                        value += "," + listItems[j].value;
                                }
                            }
                            break;
                        default:
                            value = "";
                            break;
                    }
                    label = GetAttribute(control, "displayName");
                    if (label == "" || label == undefined)
                        label = control.id;

                    xml += "&lt;FormElement ID=\"" + GetAttribute(control, "objectId") + "\" controlId=\"" + control.id + "\" label=\"" + ChangeSpecialCharacters(label) + "\" value=\"" + ChangeSpecialCharacters(value) + "\" type=\"" + GetAttribute(control, "objectType").toLowerCase() + "\" /&gt;";
                }
            }
            xml = ChangeTokens(xml, id);
            formsResponseXmlControlId = formProperties.HdnResponseXml;
            //formsThankYouUrl = formProperties.ThankYouUrl;
            //formsFormId = formProperties.FormId;

            document.getElementById(formsResponseXmlControlId).value = ChangeHiddenControlCharacters(xml);

            if (typeof FormContainer_SaveForm == 'function')
                FormContainer_SaveForm(controlIds, xml);

            eval(callBackId).callback('FormData', xml);

            if (formProperties.SubmitImmediate == "true")
                Forms_OnCallbackComplete();
        }
        return false;
    }
}

function ViewPollResults(callBackId) {
    abortFormRequest = true;
    eval(callBackId).callback('FormData');

    return false;
}

function PreventSubmit(callBackId, formId) {
    alert(clRsMessage["YouHaveVotedAlready"]);

    eval(callBackId).callback(formId);

    return false;
}

function SubmitAgain(callBackId, formId) {
    eval(callBackId).callback(formId);

    return false;
}

function ChangeTokens(str, id) {
    var replacedString = str;
    if (replacedString != null) {
        replacedString = replacedString.replace(new RegExp("@PageUrl@", "g"), formProperties.PageUrl);
        replacedString = replacedString.replace(new RegExp("@PageTitle@", "g"), formProperties.PageTitle);
        replacedString = replacedString.replace(new RegExp("@Date@", "g"), formProperties.Date);
        replacedString = replacedString.replace(new RegExp("@IP@", "g"), formProperties.IP);
        replacedString = replacedString.replace(new RegExp("@PageId@", "g"), formProperties.PageId);
    }
    return replacedString;
}

function ChangeSpecialCharacters(str) {
    var replacedString = str;
    if (replacedString != null) {
        replacedString = replacedString.replace(new RegExp("&", "g"), "&amp;");
        replacedString = replacedString.replace(new RegExp("<", "g"), "splt;");
        //replacedString = replacedString.replace(new RegExp("<", "g"), "&lt;");
        replacedString = replacedString.replace(new RegExp(">", "g"), "&gt;");
        replacedString = replacedString.replace(new RegExp("\"", "g"), "&quot;");
        replacedString = replacedString.replace(new RegExp("'", "g"), "\\'");
        replacedString = replacedString.replace(new RegExp("\n", "g"), " ");
    }
    return replacedString;
}

function ChangeToOriginalCharacters(str) {
    var replacedString = str;
    if (replacedString != null) {
        replacedString = replacedString.replace(new RegExp("&amp;", "g"), "&");
        replacedString = replacedString.replace(new RegExp("&lt;", "g"), "<");
        replacedString = replacedString.replace(new RegExp("&gt;", "g"), ">");
        replacedString = replacedString.replace(new RegExp("&spamp;", "g"), "&");
        replacedString = replacedString.replace(new RegExp("&doublequot;", "g"), "\"");
        replacedString = replacedString.replace(new RegExp("&splt;", "g"), "<");
        replacedString = replacedString.replace(new RegExp("splt;", "g"), "<");
    }
    return replacedString;
}

function ChangeHiddenControlCharacters(str) {
    var replacedString = str;
    if (replacedString != null) {
        replacedString = replacedString.replace(new RegExp("&amp;", "g"), "&");
        replacedString = replacedString.replace(new RegExp("&spamp;", "g"), "&");
        replacedString = replacedString.replace(new RegExp("&doublequot;", "g"), "\"");
        replacedString = replacedString.replace(new RegExp("&splt;", "g"), "<");
        replacedString = replacedString.replace(new RegExp("splt;", "g"), "<");
    }
    return replacedString;
}

function FormContainer_OnCallbackComplete() {
    if (typeof formProperties != "undefined" && typeof formProperties.DPFn != "undefined" &&
         typeof eval(formProperties.DPFn) == 'function')
        eval(formProperties.DPFn)();
    if (typeof IntializeFormDatePicker == 'function')
        IntializeFormDatePicker();

    if (Data) {
        //OnCallbackComplete();
    }
    else if (!abortFormRequest) {
        var responseXmlObj = document.getElementById(formProperties.HdnResponseXml);
        var url = formProperties.ThankYouUrl;
        var responseXml = "";
        if (responseXmlObj)
            responseXml = responseXmlObj.value;

        if (formProperties.WatchId != '')
            iAPPSTracker(formProperties.WatchId);

        setTimeout(function () {
            if (typeof FormContainer_OnBeforeFormSubmit == 'function')
                FormContainer_OnBeforeFormSubmit(url, responseXml, formProperties.FormId, isSystemUser);

            if (typeof FormContainer_OnFormSubmit == 'function')
                FormContainer_OnFormSubmit(url, responseXml, formProperties.FormId, isSystemUser);
            else if (url != "")
                post(url, responseXml);
            //window.location.href = url;  
        }, 10); 
    }
}

function post(url, responseXml) {
    var temp = document.createElement("form");
    temp.action = url;
    temp.method = "POST";
    temp.style.display = "none";

    var opt = document.createElement("textarea");
    opt.name = "hiddenResponseXml";
    opt.value = responseXml;
    temp.appendChild(opt);

    document.body.appendChild(temp);
    temp.submit();

    return temp;
}


var diwindow;
function UploadClientFile(iconImg) {
    diwindow = dhtmlmodal.open('ClientFileUps', 'iframe', '/ContextMenuUserControls/UploadFormAttachment.aspx?dir=' + iconImg.getAttribute("formTitle") + '&subdir=' + iconImg.id.replace("_img", "") + '&controlId=' + iconImg.id.replace("_img", ""), 'Display Item Upload', 'width=290px,height=216px,center=1,resize=0,scrolling=1');
    diwindow.onclose = function () {
        var a = document.getElementById('ClientFileUps');
        var ifr = a.getElementsByTagName("iframe");
        window.frames[ifr[0].name].location.replace("about:blank");
        return true;
    }
}

function SetClientFilePath(controlId, value) {
    if (value.lastIndexOf('/') > -1) {
        document.getElementById(controlId).setAttribute("selectedFile", value);
        document.getElementById(controlId + "_txt").value = value.substring(value.lastIndexOf('/') + 1);
    }
}

function CloseDialogPopup() {
    parent.previewPopup.hide();
}



function showPage(callBackId, pageNo) {
    if (Data) {
        alert(clRsMessage["PleaseSaveBeforePaging"]);
    }
    else {
        UpdateClientValues("Paging", pageNo, callBackId);

        eval(callBackId).callback('Paging', pageNo);
    }

    return false;
}

function sortCLList(callBackId, sortColumn, sortOrder) {
    if (Data) {
        alert(clRsMessage["PleaseSaveBeforeSorting"]);
    }
    else {
        if (sortOrder.toLowerCase() == "asc")
            sortOrder = "DESC";
        else
            sortOrder = "ASC";

        UpdateClientValues("Sorting", sortColumn + " " + sortOrder, callBackId);

        eval(callBackId).callback('Sorting', sortColumn + "^" + sortOrder);
    }

    return false;
}

function sortCLListByQuery(callBackId, sortQuery) {
    if (Data) {
        alert(clRsMessage["PleaseSaveBeforeSorting"]);
    }
    else {
        UpdateClientValues("Sorting", sortQuery, callBackId);

        eval(callBackId).callback('SortQuery', sortQuery);
    }

    return false;
}

function filterCLList(callBackId, filterQuery) {
    if (Data) {
        alert(clRsMessage["PleaseSaveBeforeFiltering"]);
    }
    else {
        UpdateClientValues("Filtering", filterQuery, callBackId);

        eval(callBackId).callback('Filtering', filterQuery);
    }

    return false;
}

function UpdateClientValues(operation, value, callBackId) {
    var clientValue = document.getElementById(callBackId + "_ClientValues").value;

    var filterValue = "";
    var sortValue = "";
    var pageNo = "";
    var arrClientVal = clientValue.split('^');
    if (arrClientVal.length == 3) {
        pageNo = arrClientVal[0];
        sortValue = arrClientVal[1];
        filterValue = arrClientVal[2];
    }
    switch (operation) {
        case "Paging":
            pageNo = value;
            break;
        case "Sorting":
            sortValue = value;
            break;
        case "Filtering":
            filterValue = value;
            break;
        default:
            clientValue = "";
            break;
    }

    document.getElementById(callBackId + "_ClientValues").value = pageNo + "^" + sortValue + "^" + filterValue;
}

function ApplyDate(icon) {
    return false;
}

function AssignDateControl(controlId, format) {
    format = format.replace("yyyy", "yy");

    var yRange = '-10:+10';
    if ($("input#datePickerYearRange").length > 0)
        yRange = "-" + $("input#datePickerYearRange").val() + ":+" + $("input#datePickerYearRange").val();

    $("#" + controlId).children('IMG').hide();
    $("#" + controlId).children('INPUT').datepicker({
        showOn: 'button',
        buttonImage: $("#" + controlId).children('IMG').attr("src"),
        buttonImageOnly: true,
        buttonText: frmSelDateText,
        dateFormat: format,
        changeMonth: true,
        changeYear: true,
        yearRange: yRange
    });
}

function IntializeFormDatePicker() {
    $('[objectType="datepicker"]').each(function (index) {
        var format = $(this).attr("customFormat");
        if (!format || format == "")
            format = $(this).attr("format");
        format = format.replace("yyyy", "yy");

        var yRange = '-10:+10';
        if ($("input#datePickerYearRange").length > 0)
            yRange = "-" + $("input#datePickerYearRange").val() + ":+" + $("input#datePickerYearRange").val();

        $(this).children('IMG').hide();
        $(this).children('INPUT').datepicker({
            showOn: 'button',
            buttonImage: $(this).children('IMG').attr("src"),
            buttonImageOnly: true,
            buttonText: frmSelDateText,
            dateFormat: format,
            changeMonth: true,
            changeYear: true,
            yearRange: yRange
        });
    });
}
function AddComment(txtNameId, txtEmailId, txtCommentsId, txtCaptchaId, txtParentId) {
    var txtName = document.getElementById(txtNameId);
    var txtEmail = document.getElementById(txtEmailId);
    var txtComments = document.getElementById(txtCommentsId);
    var txtCaptcha = document.getElementById(txtCaptchaId);
    var txtParent = document.getElementById(txtParentId);

    if (txtName && txtName.value == "") {
        alert(rsMessage["EnterName"]);
        txtName.focus();
        return false;
    }

    if (txtEmail) {
        if (txtEmail.value == "") {
            alert(rsMessage["EnterEmail"]);
            txtEmail.focus();
            return false;
        }
        var CheckForEmail = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
        if (!CheckForEmail.test(txtEmail.value)) {
            alert(rsMessage["ValidEmail"]);
            txtEmail.focus();
            return false;
        }
    }

    if (txtComments) {
        value = txtComments.value.replace(new RegExp("[ \t\r\n]+$", "g"), "");

        if (value == "") {
            alert(rsMessage["Comment"]);
            txtComments.focus();
            return false;
        }
    }

    if (txtCaptcha) {
        if (txtCaptcha.value == "") {
            alert(rsMessage["CaptchaText"]);
            txtCaptcha.focus();
            return false;
        }
        if (document.getElementById(hiddenCaptchaId).value != txtCaptcha.value) {
            alert(rsMessage["CaptchaCorrectText"]);
            txtCaptcha.focus();
            return false;
        }
    }

    if (document.getElementById(hiddenNameId) && txtName) {
        document.getElementById(hiddenNameId).value = txtName.value;
        txtName.value = "";
    }

    if (document.getElementById(hiddenEmailId) && txtEmail) {
        document.getElementById(hiddenEmailId).value = txtEmail.value;
        txtEmail.value = "";
    }

    if (document.getElementById(hiddenCommentId) && txtComments) {
        document.getElementById(hiddenCommentId).value = autolink(txtComments.value);
        txtComments.value = "";
    }

    if (document.getElementById(hiddenParentId) && txtParent)
        document.getElementById(hiddenParentId).value = txtParent.value;

    return true;
}

function autolink(s) {
    var hlink = /\s(ht|f)tp:\/\/([^ \,\;\:\!\)\(\"\'\<\>\f\n\r\t\v])+/g;
    return (s.replace(hlink, function ($0, $1, $2) {
        s = $0.substring(1, $0.length);
        // remove trailing dots, if any
        while (s.length > 0 && s.charAt(s.length - 1) == '.')
            s = s.substring(0, s.length - 1);
        // add hlink
        return " " + s.link(s);
    }
                     )
           );
}

function replyToComment(txtParentId, parentId) {
    var txtParent = document.getElementById(txtParentId);

    if (txtParent)
        txtParent.value = parentId;

    return true;
}

function initCommentBox(commentBox) {
    if (commentBox)
        commentBox.value = commentBox.value.replace(new RegExp("^[ \t\r\n]+", "g"), "");

    setCursor(commentBox, commentBox.value.length);

    return false;
}

function setCursor(elem, caretPos) {
    if (elem != null) {
        if (elem.createTextRange) {
            var range = elem.createTextRange();
            range.move('character', caretPos);
            range.select();
        }
        else {
            if (elem.selectionStart) {
                elem.focus();
                elem.setSelectionRange(caretPos, caretPos);
            }
            else
                elem.focus();
        }
    }
}

function MoveRatings(ratingId, containerId) {

    var ratingElement = document.getElementById(ratingId);
    var container = document.getElementById(containerId);

    var allrating = ratingElement.innerHTML;

    container.innerHTML = allrating;

    ratingElement.parentNode.removeChild(ratingElement);

}

function showCommentsPage(pageNo) {
    document.getElementById(hiddenCommentPageNoId).value = pageNo;
    eval(document.getElementById(hiddenCommentEventReferenceId).value);

    return false;
}

function sortCommentsPage(sortOrder) {
    document.getElementById(hiddenCommentPageNoId).value = "1";
    document.getElementById(hiddenCommentSortOrderId).value = sortOrder;
    eval(document.getElementById(hiddenCommentEventReferenceId).value);

    return false;
}
function showBlogPage(pageNo) {
    document.getElementById(hiddenPageNoId).value = pageNo;
    eval(document.getElementById(hiddenEventReferenceId).value);

    return false;
}
function AddRating(hiddenValueControlId, value) {
    if (document.getElementById(hiddenValueControlId) && value) {
        document.getElementById(hiddenValueControlId).value = value;
    }

    return true;
}


function AddRatingForNonAutoSave(control, hiddenValueControlId, value, imagePath, seq, maxLevels, defaultImagePath) {
    if (document.getElementById(hiddenValueControlId) && value) {
        document.getElementById(hiddenValueControlId).value = value;
        oldImage = imagePath;
        var curCtrlId = control.getAttribute("id");
        var lastIndexOfSeq = curCtrlId.lastIndexOf(seq);

        var curCtrlIDWithoutSeq = curCtrlId.substring(0, lastIndexOfSeq);

        for (var k = seq; k > 0; k--) {
            var prevLevelCtrlId = curCtrlIDWithoutSeq + k;
            var prevLevel = document.getElementById(prevLevelCtrlId);
            if (prevLevel != null)
                prevLevel.src = imagePath;
        }

        for (var j = seq + 1; j <= maxLevels; j++) {
            var nextLevelCtrlId = curCtrlIDWithoutSeq + j;
            var nextLevel = document.getElementById(nextLevelCtrlId);
            if (nextLevel != null)
                nextLevel.src = defaultImagePath;
        }
    }

    return false;
}

function PreventVoting() {
    alert(rsMessage["PreventVoting"]);
    return false;
}


var oldImage;
function RatingOnHover(control, ratingLabelId, imageSrc, label) {

    oldImage = control.src;
    control.src = imageSrc;
    document.getElementById(ratingLabelId).innerHTML = label;
}

function RatingOnHoverOut(control, ratingLabelId, imageSrc, label) {
    control.src = oldImage;
    document.getElementById(ratingLabelId).innerHTML = label;
}


function GetRatingsBreakdown(clientId) {

}

function CloseAddPostPopup(operation) {
    if (operation.toLowerCase() == 'cancel') {
        viewPopupWindow.hide();
    }
    else if (operation.toLowerCase() == 'save') {
        window.location.href = window.location.href;
    }
}
