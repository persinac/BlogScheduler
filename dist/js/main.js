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
    response += '<div class="dropdown">';
    response += '<button id="month_dd_btn" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">';
    response += 'Month ';
    response += '<span class="caret"></span></button>';
    response += '<ul class="dropdown-menu" id="month_dropdown">';
    response += '<li><a href="#" data-month="JAN">January</a></li>';
    response += '<li><a href="#" data-month="FEB">Febuary</a></li>';
    response += '<li><a href="#" data-month="MAR">March</a></li>';
    response += '<li><a href="#" data-month="APR">April</a></li>';
    response += '<li><a href="#" data-month="MAY">May</a></li>';
    response += '<li><a href="#" data-month="JUN">June</a></li>';
    response += '<li><a href="#" data-month="JULY">July</a></li>';
    response += '<li><a href="#" data-month="AUG">August</a></li>';
    response += '<li><a href="#" data-month="SEP">September</a></li>';
    response += '<li><a href="#" data-month="OCT">October</a></li>';
    response += '<li><a href="#" data-month="NOV">November</a></li>';
    response += '<li><a href="#" data-month="DEC">December</a></li>';
    response += '</ul>';
    response += '</div>';
    response += '<div class="dropdown">';
    response += '<button id="year_dd_btn" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">';
    response += 'Year';
    response += '<span class="caret"></span></button>';
    response += '<ul class="dropdown-menu" id="year_dropdown">';
    response += '<li><a href="#" data-year="17">2017</a></li>';
    response += '<li><a href="#" data-year="18">2018</a></li>';
    response += '<li><a href="#" data-year="19">2019</a></li>';
    response += '<li><a href="#" data-year="20">2020</a></li>';
    response += '<li><a href="#" data-year="21">2021</a></li>';
    response += '<li><a href="#" data-year="22">2022</a></li>';
    response += '</ul>';
    response += '</div>';
    response += '<div><input class="margin_10_px" type="file" name="fileToUpload" id="fileToUpload"></div>';
    response += '<div><input class="margin_10_px" type="submit" value="Upload File" name="submit" onclick="UploadFile();"></div>';
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
    var month = $("#month_dropdown li a");
    var year = $("#year_dropdown li a");
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

function ListSelectorPlaceholder(obj) {
    if(obj.data().month !== undefined) {
        //console.log("Month: " + obj.data().month)
        $("#month_dd_btn").html(obj.text() + ' <span class="caret"></span>');
        $("#month_dd_btn").val(obj.text());
    } else {
        //console.log("Year: " + obj.data().year)
        $("#year_dd_btn").html(obj.text() + ' <span class="caret"></span>');
        $("#year_dd_btn").val(obj.text());
    }
}