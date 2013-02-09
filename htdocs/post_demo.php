<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html> 
    <head> 
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8"> 
        <title>文件发送</title> 
    </head> 
    <body> 
        <form action="/post/" enctype="multipart/form-data" method="post"> 
            <table> 
                <tr><td>ID<input type="text" name="id" /></td></tr> 
                <tr><td>USERNAME<input type="text" name="username" /></td></tr> 
                <tr><td><input type="file" name="myfile[]" /></td></tr> 
                <tr><td><input type="file" name="myfile[]" /></td></tr> 
            </table> 
            <input type="submit" /> 
        </form> 
    </body> 
</html> 