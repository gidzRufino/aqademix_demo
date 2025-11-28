function libRequest(data)
    {
      //alert(num);
       
        var setAction = document.getElementById('setLibAction').value;
        if(setAction=='addBook'){
           //alert(data);
        }
        if (data=="")
        {
        document.getElementById("output").innerHTML="";
        return;
        }
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
            var setAction = document.getElementById('setLibAction').value;
                    
            switch(setAction){
                case 'addCategory':
                     document.getElementById("inputCategory").innerHTML=xmlhttp.responseText;
                     document.getElementById('setLibAction').value='addBook';
                     //document.getElementById("resultSection").innerHTML='Category Added';
                     
                break;
                
                case 'addDeweyDecimal':
                    document.getElementById("inputDeweyDecimal").innerHTML=xmlhttp.responseText;
                     document.getElementById('setLibAction').value='addBook';
                break;
                case 'addBook':
                     document.getElementById("tableResult").innerHTML=xmlhttp.responseText;

                break;
                case 'setSearchBook':
                     document.getElementById("goLendSearch").innerHTML=xmlhttp.responseText;

                break;
                case 'goSearchLend':
                     document.getElementById("tableLendResult").innerHTML=xmlhttp.responseText;

                break;
                case 'goSearchInfo':
                     document.getElementById("tableResult").innerHTML=xmlhttp.responseText;

                break;
                case 'getOptionInfo':
                     document.getElementById("goSearch").innerHTML=xmlhttp.responseText;

                break;
                case 'mainSearch':
                     document.getElementById("mainSearchResult").innerHTML=xmlhttp.responseText;

                break;
                case 'mainOption':
                     document.getElementById("mainSearch").innerHTML=xmlhttp.responseText;

                break;
                
                case 'scanRfid':
                     document.getElementById("scanResult").innerHTML=xmlhttp.responseText;

                break;
                case 'lendSave':
                     document.getElementById("mainSearchResult").innerHTML=xmlhttp.responseText;

                break;
                case 'getBorrowedBook':
                   document.getElementById("tableLendResult").innerHTML=xmlhttp.responseText;

                break;
                // gads
                case 'addFines':
                    document.getElementById("inputFines").innerHTML=xmlhttp.responseText;
                    document.getElementById('setLibAction').value='addFines';
                break;
                case 'getBorrowedBooksReport':
                    document.getElementById("tableResultLibReport").innerHTML=xmlhttp.responseText;
                break;
                case 'getReturnedBooksReport':
                    document.getElementById("tableResultLibReport").innerHTML=xmlhttp.responseText;
                break;
                case 'getDueDateBooksReport':
                    document.getElementById("tableResultLibReport").innerHTML=xmlhttp.responseText;
                break;
               
            }        
           }
        }
         switch(setAction){
           
            case 'addCategory':
                xmlhttp.open("GET", "../utilities/addLibCategory/"+data, true);
            break; 
            case 'addFines':
                xmlhttp.open("GET", "../utilities/addLibFines/"+data, true);
            break;
 
            case 'addDeweyDecimal':
                xmlhttp.open("GET", "../utilities/addLibDewey/"+data, true);
            break;
            case 'addBook':
                xmlhttp.open("GET", "../utilities/addLibBooks/"+data, true);
            break; 
            case 'setSearchBook':
                xmlhttp.open("GET", "../utilities/setSearchOption/"+data, true);
            break; 
            case 'goSearchLend':
                xmlhttp.open("GET", "../utilities/searchBooks/"+data, true);
            break; 
            case 'getOptionInfo':
                xmlhttp.open("GET", "../utilities/setSearchOption/"+data, true);
            break; 
            case 'goSearchInfo':
                xmlhttp.open("GET", "../utilities/searchInfo/"+data, true);
            break; 
            
            case 'mainSearch':
                xmlhttp.open("GET", "../utilities/searchBooks/"+data, true);
            break; 
            case 'mainOption':
                xmlhttp.open("GET", "../utilities/setSearchOption/"+data, true);
            break; 
            case 'scanRfid':
                xmlhttp.open("GET", "../utilities/scanRfid/"+data, true);
            break; 
            case 'lendSave':
                xmlhttp.open("GET", "../utilities/lendSave/"+data, true);
            break; 
            case 'getBorrowedBook':
                xmlhttp.open("GET", "../utilities/getBorrowedBook/"+data, true);
            break; 
            case 'getBorrowedBooksReport':
                xmlhttp.open("GET", "../utilities/getBorrowedBooksReport/"+data, true);
            break;
            case 'getReturnedBooksReport':
                xmlhttp.open("GET", "../utilities/getReturnedBooksReport/"+data, true);
            break;
            case 'getDueDateBooksReport':
                xmlhttp.open("GET", "../utilities/getDueDateBooksReport/"+data, true);
            break;
             
             
    }
        xmlhttp.send();
}

