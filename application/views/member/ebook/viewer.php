<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ebook Content</title>
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/bootstrap.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/font-awesome.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/all.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/style.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/responsive.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/colors.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/css/pdf.css');?>">
</head>
<body style="height: 100vh;">
    <!--<div id="app">-->
    <!--    <div id="toolbar">-->
    <!--        <div id="pager">-->
    <!--            <button data-pager="prev">prev</button>-->
    <!--            <button data-pager="next">next</button>-->
    <!--        </div>-->
    <!--        <div id="scale">-->
    <!--            <button data-scale="minus">minus</button>-->
    <!--            <button data-scale="plus">plus</button>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--    <div id="viewport" role="main"></div>-->
    <!--</div>-->
    
    <embed src="<?=$file.'#toolbar=0&navpanes=0&scrollbar=0';?>" type="application/pdf" width="100%" height="100%" />

    <script src="<?=base_url('assets/micrology-master/js/jquery.min.js');?>"></script>
    <script src="<?=base_url('assets/micrology-master/js/bootstrap.min.js');?>"></script>
    <script src="<?=base_url('assets/micrology-master/js/all.js');?>"></script>
    <script src="<?=base_url('assets/micrology-master/js/custom.js');?>"></script>
    <script src="<?=base_url('assets/pdfjs-2.2.228/build/pdf.js');?>"></script>
    <script src="<?=base_url('assets/pdfjs-2.2.228/build/pdf.worker.js');?>"></script> 
    <script src="<?=base_url('assets/js/pdf.js');?>"></script>
    <script>
        // window.onload = () => {
        //     initPDFViewer('<?=base_url('course/ebook/content/example.pdf');?>');
        // }
        // $(document).ready(function() {
        //     var pdf = $.ajax('<?=$url;?>')
        //         .done(function(pdfData) {
        //             // console.log('data: ' + pdfData);
        //             initPDFViewer(atob(pdfData));
        //         })
        //         .fail(function(response) {
        //             console.log(response.responseText);
        //         });
        // })
    </script>
</body>
</html>