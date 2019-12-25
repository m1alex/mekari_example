
$(document).ready(function() {
    // init page
    refreshDataOnPage();
    
    
    // add item handler
    $(document).on("submit", "#add-item-form", function(event) { 
        console.log('addItem');
        
        event.preventDefault();
        
        addItem($(this));
        
        return false;
    });
    
    
    // remove item handler
    $(document).on("submit", ".remove-item-form", function(event) { 
        console.log('removeItem');
        
        event.preventDefault();

        removeItem($(this));
        
        return false;
    });
    
    
     // remove selected items handlers
    $(document).on("submit", "#remove-selected-items-form", function(event) { 
        console.log('removeSelectedItems');
         
        event.preventDefault();
        
        removeSelectedItems($(this));
        
        return false;
    });
    
    
    // remove all items handlers
    $(document).on("submit", "#remove-all-items-form", function(event) { 
        console.log('removeAllItems');
         
        event.preventDefault();
        
        removeAllItems($(this));
        
        return false;
    });
});


function refreshDataOnPage()
{
    console.log('refreshDataOnPage');
    
    $("#item-title").val('');
    
    var data = loadItems();
    fillItemsList(data.responseJSON);
}


function addItem(form)
{
    var postData = form.serialize();
    var formURL = form.attr("action");
    var method = form.attr("method");
    
    $.ajaxSetup({ cache: false });
    $.ajax({
        url : formURL,
        type: method,
        data: postData,
        dataType: "json",
        success: function(data, textStatus, jqXHR) {
            $("#item-title").val('');
            
            var data = loadItems();
            fillItemsList(data.responseJSON);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('something wrong...');
        }
    });
}


function removeItem(form)
{
    var postData = form.serialize();
    var formURL = form.attr("action");
    var method = form.attr("method");
        
    $.ajaxSetup({ cache: false });
    $.ajax({
        url : formURL,
        type: method,
        data: postData,
        dataType: "json",
        success: function(data, textStatus, jqXHR) {
            var data = loadItems();
            fillItemsList(data.responseJSON);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('something wrong...');
        }
    });
}


function removeAllItems(form)
{
    var postData = form.serialize();
    var formURL = form.attr("action");
    var method = form.attr("method");
        
    $.ajaxSetup({ cache: false });
    $.ajax({
        url : formURL,
        type: method,
        data: postData,
        dataType: "json",
        success: function(data, textStatus, jqXHR) {
            var data = loadItems();
            fillItemsList(data.responseJSON);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('something wrong...');
        }
    });
}


function removeSelectedItems(form)
{
    var postData = form.serialize();
    var formURL = form.attr("action");
    var method = form.attr("method");
    
    var selected = [];
    $("input[name='marked[]']:checked:enabled").each(function() {
        selected.push($(this).attr('value'));
    });
        
    $.ajaxSetup({ cache: false });
    $.ajax({
        url : formURL,
        type: method,
        data: postData + "&" + $.param({"selected":selected}),
        dataType: "json",
        success: function(data, textStatus, jqXHR) {
            var data = loadItems();
            fillItemsList(data.responseJSON);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('something wrong...');
        }
    });
}


function loadItems()
{
    console.log('loadItems');
    
    $.ajaxSetup({ cache: false });
   
    var data = $.ajax({
        async : false,
        url   : "/items",
        type  : "GET",
        data  : {},
        dataType: "json",
        success: function(data, textStatus, jqXHR) {
            return {
                "status": "success",
                "data": data
            };
        },
        error: function(jqXHR, textStatus, errorThrown) {
            return {
                "status": "error",
                "data": {},
                "error": errorThrown
            };
        }
    });
    
    console.log(data);
    
    return data;
}


function fillItemsList(data)
{
    console.log('fillItemsList');
    
    $("#items-list tbody").empty();
    
    var csrf_token = $("#csrf").text();
    var domain = $("#domain").text();
    
    if (data.data.length > 0) {
        $.each(data.data, function(i, item) {
            $("#items-list tbody").append(
                "<tr id=\"item-row-" + item.id + "\">"
                    + "<td class=\"table-text\">"
                        + "<input type=\"checkbox\" name=\"marked[]\" value=\"" + item.id + "\" id=\"marked-" + item.id + "\">"
                        + "</td>"
                    + "<td class=\"table-text\">" + item.id + "</td>"
                    + "<td class=\"table-text\">" + item.title + "</td>"
                    + "<td>" + makeRemoveControl(item.id, csrf_token, domain) + "</td>"
                    + "</tr>" 
            );
        });
    } else {
        $("#items-list tbody").append(
            "<tr id=\"item-row-empty\">"
                + "<td class=\"table-text\" colspan=\"3\"><label class=\"control-label\">Items are not added</label></td>"
                + "</tr>" 
        );
    }  
    
}


function makeRemoveControl(itemId, csrfToken, domain)
{
    var controlHtml = "";
    
    controlHtml += '<form class="remove-item-form" action="' + domain + '/items/remove/' + itemId + '" method="POST">';
    controlHtml += '<input type="hidden" name="_token" value="' + csrfToken + '">';
    controlHtml += '<input type="hidden" name="_method" value="DELETE">';
    controlHtml += '<button type="submit" id="remove-item-' + itemId + '" class="btn btn-danger">';
    controlHtml += '<i class="fa fa-btn fa-trash"></i> Remove ';
    controlHtml += '</button>';
    controlHtml += '</form>';
    
    return controlHtml;
}
