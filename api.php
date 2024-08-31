/*
* Local PlusStore API for PlusCarts
* Copyright 2024 Wolfgang Stubig
* Version: v1.0.0
*
* missing features (some might be added, but most don't make sense in a local environment):
*  - Search function
*  - "Popular ROMs"
*  - "Recently added ROMs"
*  - "My Favourite ROMs"
*  - "My Recently Played ROMs"
*  - Text file reading
*  - ZIP/tar file unpacking
*  - High Score Club list
*  - PlusCart chat
*/

SSJSKey = 'wa4e76yhefy54t4a'


function plusCartFileType(filename){
    if(filename.endsWith('.txt'))
        return "1 ";
    return "2 ";
}

var responseBody = '00\n';
res.getFile('/' + req.arguments.p, function(file) {
    if (file.error) {
        res.end('0 000000 error\n');
    } else if (file.isFile) {
        res.renderFileContents(file);
    } else if (file.isDirectory) {
        if(file.origpath != '/')
            responseBody += '0 000000 ..\n';
        file.getDirContents(function(results) {
            var dirs = [];
            var files = [];
            results.forEach((element) => {
                if (element.isDirectory){
                    dirs.push(element);
                }else if (element.isFile){
                    files.push(element);
                }
            });
            dirs.forEach((dir) => {
                responseBody += '1 000000 ' + dir.name + '\n';
            });
            files.forEach((file) => {
                responseBody += plusCartFileType(file.name) + file.size.toString().padStart(6, '0') + ' ' + file.name + '\n';
            });
            res.write(responseBody);
            res.end();
        });
    } else {
        res.end('0 000000 file/dir not found\n');
    }
})
