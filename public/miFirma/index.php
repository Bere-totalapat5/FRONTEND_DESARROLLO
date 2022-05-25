<!doctype html>
<html>

<head>
    <title>Firma documentos</title>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <link rel="stylesheet" href="css/bootstrap.css" />
    <script src="Scripts/Firma.js"></script>
    <style>
        .path {
            display: none;
        }

        .lnk {
            display: none;

        }
    </style>
    <script>
        //Objeto principal de firma
        var firma = new fielnet.Firma({
            subDirectory: "./Scripts",
            controller: "Controller.php",
            ajaxAsync: true
        });

        //asociamos eventos de lectura certificado digital, llave privada y pfx

        $(function() {
            //Par de llaves
            firma.readCertificate("certificate");
            firma.readPrivateKey("privateKey");

            //PFX
            firma.readPfx("pfxFile");
        });

        //Funciones para validar el acceso a las llaves privadas

        function openKeyPairs() {
            var pass = $("#passKeyPairs").val();
            if (pass) {
                firma.validateKeyPairs(pass, function(objResult) {
                    if (objResult.state == 0) {
                        showSignaturePanel();
                    } else {
                        alert(objResult.description);
                    }
                });

            }

        }

        function openPfx() {
            var pass = $("#passPfx").val();
            if (pass) {
                firma.openPfx(pass, function(objResult) {
                    if (objResult.state == 0) {
                        showSignaturePanel();
                    } else {
                        alert(objResult.description);
                    }
                });

            }
        }

        function showSignaturePanel() {
            $("#pnlFirma").css("display", "none");
            $("#panelFile").show();
        }

        function uploadFile() {
            var fDocumento = document.getElementById("fDocumento");
            if (fDocumento) {
                var files = fDocumento.files;
                if (files) {
                    var file = files[0];

                    var fileData = new FormData();
                    fileData.append("file", file);

                    $.ajax({
                        url: 'Upload.php',
                        type: "POST",
                        contentType: false, // Not to set any content header  
                        processData: false, // Not to process data  
                        data: fileData,
                        cache: false,
                        dataType: "json",
                        xhr: function() {
                            var myXhr = $.ajaxSettings.xhr();
                            if (myXhr.upload) {
                                myXhr.upload.addEventListener('progress', function(e) {
                                    var percent_loaded = Math.ceil((e.loaded / e.total) * 100);
                                    $(".progress-bar").css("width", percent_loaded + "%").html(
                                        percent_loaded + "%");
                                    if (e.lengthComputable) {
                                        console.log(e.loaded + " " + e.total);
                                    }

                                }, false);
                            }
                            return myXhr;
                        },
                        success: function(data, status, jqhxr) {
                            if (data.status == 0) {
                                var path = data.path;
                                path = atob(path);
                                $("#origen").val(path);
                                $("#digest").val(data.digest);
                                $(".path").css("display", "table-row");
                                $("#btnSubirArchivo").css("display", "none");
                                $("#btnFirmar,#btnFirmarDigestion").show();
                            } else {
                                alert(data.description);
                            }
                        },
                        error: function(err) {

                        }
                    });
                }
            }
        }

        /*
           Método útil cuando se tiene el blob que representa el documento
         */


        function signFile() {
            var files = fDocumento.files;
            if (files) {
                var file = files[0];
                $("#exampleModal").modal();
                firma.addExtraParameters("&filePath=" + $("#origen").val());
                firma.signPKCS7WithPDFCreation(file, 10, fielnet.Digest.SHA2, function(percentage) {
                    console.log("Porcentaje lectura documento: " + percentage);
                }, function(objResult) {
                    $("#exampleModal").modal("hide");
                    if (objResult.state == 0) {
                        $(".lnk").css("display", "block");
                    }
                    $("#resultado").val(JSON.stringify(objResult, null, 2));
                    $("#modalResultado").modal();
                }, function(objError) {
                    $("#exampleModal").modal("hide");
                });
            }
        }


        /*
           Método útil cuando se tiene el documento almacenado en un repositorio
         */
        function signFileDigest() {
            $("#exampleModal").modal();
            firma.addExtraParameters("&filePath=" + $("#origen").val());
            firma.signFileDigestWithPDFCreation($("#digest").val(), fielnet.Digest.SHA512, function(objResult) {
                if (objResult.state == 0) {
                    $("#exampleModal").modal("hide");
                    $(".lnk").css("display", "block");
                }
                $("#resultado").val(JSON.stringify(objResult, null, 2));
                $("#modalResultado").modal();
            });

        }
    </script>
</head>

<body>
    <div id="pnlFirma">

        <div style="width:80%; margin:auto; margin-top:5%;">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#keyPairs" aria-controls="home" role="tab" data-toggle="tab">Par de llaves</a></li>
                <li role="presentation"><a href="#pfx" aria-controls="profile" role="tab" data-toggle="tab">PFX</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="keyPairs">
                    <h1>Par de llaves</h1>
                    <table class="table table-bordered table-stripped">
                        <tr>
                            <td>Seleccione certificado digital (.cer) <input type="file" id="certificate" /></td>
                        </tr>
                        <tr>
                            <td>Seleccione llave privada (.key) <input type="file" id="privateKey" /></td>
                        </tr>
                        <tr>
                            <td><input type="password" id="passKeyPairs" class="form-control" /></td>
                        </tr>
                        <tr class="text-right">
                            <td><input type="button" value="Acceder" class="btn btn-primary" onclick="openKeyPairs(); return false;" />
                        </tr>
                    </table>
                </div>
                <div role="tabpanel" class="tab-pane" id="pfx">
                    <h1>Encapsulado PFX</h1>
                    <table class="table table-bordered table-stripped">
                        <tr>
                            <td>Seleccione encapsulado (.pfx) <input type="file" id="pfxFile" /></td>
                        </tr>
                        <tr>
                            <td><input type="password" id="passPfx" class="form-control" /></td>
                        </tr>
                        <tr class="text-right">
                            <td>
                                <input type="button" value="Acceder" class="btn btn-primary" onclick="openPfx(); return false;" />
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <div id="panelFile" style="display:none; width:70%; margin:auto; margin-top:5%; ">
        <h1>Firmar documento</h1>
        <table class="table table-bordered">
            <tr>
                <td>Seleccione archivo a firmar: <input type="file" id="fDocumento" accept=".pdf" /></td>
            </tr>
            <tr class="path">
                <td>Ruta repositorio aplicativo: <input type="text" class="form-control" id="origen" readonly /></td>
            </tr>
            <tr class="path">
                <td>Huella digital documento (hash):<input type="text" class="form-control" id="digest" readonly /></td>
            </tr>
            <tr>
                <td class="text-right">
                    <input type="button" value="Subir archivo" class="btn btn-success" id="btnSubirArchivo" onclick="uploadFile(); return false;" />
                    <input type="button" value="Firmar  digestión documento" class="btn btn-primary" style="display:none;" id="btnFirmarDigestion" onclick="signFileDigest(); return false;" />
                    <input type="button" value="Firmar documento" class="btn btn-primary" style="display:none;" id="btnFirmar" onclick="signFile(); return false;" />
                    <a href="download.php?fileName=evidencia.pdf" class="lnk">Descargar PDF Blindado</a>
                    <a href="download.php?fileName=firmas.p7s" class="lnk">Descargar PKCS7</a>
                </td>
            </tr>
        </table>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
        </div>
    </div>


    <div class="modal" tabindex="-1" role="dialog" id="modalResultado">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Resultado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea readonly id="resultado" class="form-control" style="width:100%;" rows="15"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Espere</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info text-center">
                        Espere mientras el proceso finaliza
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


</body>

</html>