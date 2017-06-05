/**
 * Created by apersinger on 4/23/2017.
 */

function BuildActionsPage() {
    var response = '<div class="upload col-md-3">';
    response += '<button id="sendAdHocEmail" type="button" class="btn btn-primary btn-md margin_5_px">Send Ad Hoc Email</button>';
    response += '<button id="uplNewBlogMthSch" type="button" class="btn btn-primary btn-md margin_5_px">Upload New Blog Month Schedule</button>';
    response += '<button id="uplNewEmpList" type="button" class="btn btn-primary btn-md margin_5_px">Upload New Employee List</button>';
    response += '<button id="setUpServiceAcct" type="button" class="btn btn-primary btn-md margin_5_px">Set up Service Account</button>';
    response += '</div>';
    response += '<div id="selectedAction" class="selectedAction col-md-9">';
    response += '</div>';
    $("#dyn_content").html(response);
    //BuildServiceAccountSetup();
}

function BuildSendAdHocEmailSection() {
    var response = "";
    response += '<input type="submit" value="Send Ad Hoc Email" name="genCronData" onclick="SendAdHocEmail();"></br>';
    response += '<div id="sendMailResponse">';
    response += '</div>';
    $("#selectedAction").html(response);
}

function BuildUploadNewBlogMonthDataSection() {
    var response = "";
    response += '<input class="margin_10_px" type="file" name="fileToUpload" id="fileToUpload"></br>';
    response += '<label for="fileType" class="inlinecheckBoxLabel padding_rgt_5_px">';
    response += 'Employee List?'
    response += '</label>';
    response += '<input class="inlinecheckBox" type="checkbox" value="1", name="fileType" id="fileType" disabled>';
    response += '<input class="absolutePosition margin_10_px" type="submit" value="Upload File" name="submit" onclick="UploadFile();"></br>';
    $("#selectedAction").html(response);
}

function BuildUploadNewEmployeeListSection() {
    var response = "";
    response += '<input class="margin_10_px" type="file" name="fileToUpload" id="fileToUpload"></br>';
    response += '<label for="fileType" class="inlinecheckBoxLabel padding_rgt_5_px">';
    response += 'Employee List?'
    response += '</label>';
    response += '<input class="inlinecheckBox" type="checkbox" value="1", name="fileType" id="fileType" checked disabled>';
    response += '<input class="absolutePosition margin_10_px" type="submit" value="Upload File" name="submit" onclick="UploadFile();"></br>';
    $("#selectedAction").html(response);
}
/**
 *
 * @constructor
 *
 *
 */
function BuildServiceAccountSetup() {
    var response = '<div class="margin_10_px">';
    response += '<div class="form-group" id="svcacctipt">';
    response += '<label for="svcacctemail">Service Account Email</label>';
    response += '<input class="form-control margin_5_px" id="svcacctemail" type="text">';
    response += '<label for="svcacctpw">Service Account Password</label>';
    response += '<input class="form-control margin_5_px" id="svcacctpw" type="password">';
    response += '<input type="submit" ' +
            'class="margin_10_px"' +
        'value="Submit Service Acct" ' +
        'name="submitServiceAcct" ' +
        'onclick="SubmitServiceAccount();"></br>';
    response += '</div>';
    response += '<div id="serviceAcctResponse"></div>';
    $("#selectedAction").html(response);
}

function UploadFile() {
    var fileType = 0;
    var response = "<h3>Uploading...</h3>";
    var fileToUpload = $("#fileToUpload").prop('files')[0];
    if($("#fileType").is(':checked')) {fileType = 1};
    var formData = new FormData();
    formData.append("file",fileToUpload);
    formData.append("fileType", fileType);
    $("#dyn_content").html(response);
    $.ajax({
        type: "POST",
        url: "/CRUD/general/uploadFile.php",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
            //console.log(response);
            $("#dyn_content").html(response);
        }
    });
}

function SendAdHocEmail() {
    var response = "<h3>Sending...</h3>";
    $("#sendMailResponse").html(response);
    $.ajax({
        type: "POST",
        url: "/CRUD/cron/master.php",
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
            //console.log(response);
            $("#sendMailResponse").html(response);
        }
    });
}

function BuildBlogListTable() {
    var response = "<h3>Uploading...</h3>";
    $("#dyn_content").html(response);
    $.ajax({
        type: "GET",
        url: "/CRUD/general/homePageData.php",
        success: function(response) {
            //console.log(response);
            $("#dyn_content").html(response);
        }
    });
}

function BuildEmployeeListTable() {
    var response = "<h3>Uploading...</h3>";
    $("#dyn_content").html(response);
    $.ajax({
        type: "GET",
        url: "/CRUD/general/buildEmployeeListTable.php",
        success: function(response) {
            //console.log(response);
            $("#dyn_content").html(response);
        }
    });
}

function LoadEmployeeDetails() {
    var response = "<h3>Employee Details</h3>";
    $("#containerForTableLinkClicks").html(response);
}

function SubmitServiceAccount() {
    var response = "Submitting";
    var svcAcctEmail = $("#svcacctemail").val();
    var svcAcctPw = $("#svcacctpw").val();
    $.each($(".form-group input"), function( index, value) {
        console.log($(this).attr("id") + " : " + $(this).val());
    })
    var acctDetails = {email: svcAcctEmail, password: svcAcctPw};
    $("#serviceAcctResponse").html(response);
    $.ajax({
        type: "POST",
        url: "/CRUD/general/setServiceAccount.php",
        data: {data: JSON.stringify(acctDetails)},
        success: function(response) {
            console.log(response);
            //$("#sendMailResponse").html(response);
        }
    });


}