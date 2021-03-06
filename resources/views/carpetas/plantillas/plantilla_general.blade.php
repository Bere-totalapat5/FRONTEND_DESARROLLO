{{-- <div style="width:100%" align="center">
  <div style="max-width:640px;width:640px;min-width:640px;" > --}}
    <br>
    @if($plantilla==501) {{-- formato general--}}
      <table style="border: none;" width="100%">
        <tbody>
          <tr>
            <td rowspan="2" style="border: 0;width:50%">
              <img src="{{$ruta_publica.'/images/logo-pjcdmx-plantilla.png'}}" width="100%" style="height: 100px;" id="logo_tsj"/>
              {{-- <img src="data:image/png;base64, {{base64_encode(file_get_contents(public_path().'/images/logo-pjcdmx-plantilla.png'))}}" width="100%"/> --}}
            </td>
            <td style="border: 0; text-align:right;">
              <table style="border: none;" width="100%">
                <tbody>
                  <tr>
                    <td style="border: 0; text-align:right;">
                      <p style="font-size:14px;font-style: italic;text-align: right;">"{{$leyenda_anio}}"</p>
                    </td>
                  </tr>
                  <tr>
                    <td style="border: 0; text-align:right;">
                      {{-- <p style="text-align: right;"><img src="{{asset('/images/logo-gj-plantilla.png')}}" width="200px" align="right"></p> --}}
                      <p style="text-align: right;"><img src="{{$ruta_publica.'/images/logo-gj-plantilla.png'}}" width="200px" align="right"  style="height: 100px;" id="logo_tsj"></p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>
        </tbody>
      </table>
    @else
      <table style="border: none;" width="100%">
        <tbody>
          <tr>
            <td rowspan="2" style="border: 0;width:50%">
              {{-- <img src="{{asset('/images/logo-pjcdmx-plantilla.png')}}" width="100%"/> --}}
              <img src="{{$ruta_publica.'/images/logo-pjcdmx-plantilla.png'}}" width="100%" style="height: 100px;" id="logo_tsj"/>
            </td>
            <td style="border: 0; text-align:right;">
              <table style="border: none;" width="100%">
                <tbody>
                  <tr>
                    <td style="border: 0; text-align:right;">
                      <p style="font-size:14px;font-style: italic;text-align: right;">"{{$leyenda_anio}}"</p>
                    </td>
                  </tr>
                  <tr>
                    <td style="border: 0; text-align:right;">
                      {{-- <p style="text-align: right;"><img src="{{asset('/images/logo-gj-plantilla.png')}}" width="200px" align="right"></p> --}}
                      {{-- <p style="text-align: right;"><img src="data:image/png;base64, {{base64_encode(file_get_contents(public_path().'/images/logo-gj-plantilla.png'))}}" width="200px" align="right"></p> --}}
                    </td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>
        </tbody>
      </table>
      <p style="text-align:right;">Ciudad de M??xico a {{$fecha_oficio}}
        <br> <span style="font-weight:bold;"> Carpeta Judicial: {{$carpeta_judicial}}</span>
        <br> <span style="font-weight:bold;"> Carpeta de Investigaci??n: {{$carpeta_investigacion}}</span>
        <br> <span style="font-weight:bold;"> Imputado: @foreach($imputados as $imputado) {{$imputado['nombre_completo_mayuscula']}}. </span> @endforeach
        <br> <span style="font-weight:bold;"> V??ctima u Ofendido: {{$victimas}}</span>
        <br> <span style="font-weight:bold;"> Hechos con apariencia de delito: @foreach($imputados as $imputado) {{$imputado['delitos_mayuscula']}}. </span> @endforeach
        <br> <span style="font-weight:bold;"> Fecha de vinculaci??n a proceso: {{$fecha_vinculacion_proceso}}</span>
        <br> <span style="font-weight:bold;"> Oficio: UGJ{{$numero_ugj}}/{{$numero_oficio}}/{{date('Y')}}</span>
        <br> <span style="font-weight:bold;">Asunto: </span> <span style="font-weight:normal;">{{$asunto}}</span>
      </p>
      <br>
      <p style="text-align:left;font-weight:bold;">DIRECTOR EJECUTIVO DE LA UNIDAD DE
        <br>SUPERVISI??N DE MEDIDAS CAUTELARES Y
        <br>SUSPENSI??N CONDICIONAL DEL PROCESO.         
        <br><br>PRESENTE.
      </p>
    @endif
    
    @if($plantilla==41) {{--suspencion condicional proceso--}}
    
      <p style="text-align:justify;">
        Hago de su conocimiento que el d??a {{$audiencia['fecha_inicio_letra']}} en <span style="font-weight:bold;">Audiencia Inicial</span>, presidida por el (la) <span style="font-weight:bold;text-decoration: underline black;">{{$juez_control['titulo']}} {{$juez_control['nombre_completo']}}</span>, Juez(a) 
        de Control del Sistema Procesal Penal Acusatorio de la Ciudad de M??xico, respecto de la carpeta judicial citada al rubro, instruida en contra de 
        la persona imputada @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['nombre_completo_mayuscula']}}, </span> @endforeach determin?? <span style="font-weight:bold;"> calificar de legal su detenci??n, vincul??ndola a proceso </span> por el
        (los) hecho(s) que la ley se??ala como delito(s) de @foreach($imputados as $imputado) <span style="font-weight:normal;">{{$imputado['delitos_mayuscula']}}, </span> @endforeach cometido(s) en agravio de {{$victimas}}, concediendo la Suspensi??n Condicional del Proceso, consistente(s) en:
        <br><br>
        @foreach($condiciones as $index => $c )
        {{$c['descripcion']}} {{-- $c['detalle_adicional'] --}} {{ strlen($c['duracion']) ? 'misma que tendr?? una vigencia por '.$c['duracion'] : '' }}. <br>
        @endforeach
        <br><br>

        Asimismo, autoriz?? el plan de reparaci??n del da??o consistente en: {{$plan_reparaci??n_danio}}

        <br><br>

        Condici??n(es) que fue(ron) impuesta(s) atento al principio de proporcionalidad e idoneidad, cuya duraci??n ser?? por {{$periodo_suspension}} meses, con fundamento en lo 
        establecido en el art??culo 

        @if($materia_carpeta=='adultos')
         &nbsp; 195 fracci??n(es)  @foreach($condiciones as $index => $c ){{ explode('.',$c['descripcion'])[0]}}, @endforeach del C??digo Nacional de Procedimientos Penales; &nbsp;
        @elseif( $materia_carpeta == 'adolescentes')
          &nbsp; 102 fracci??n(es)  @foreach($condiciones as $index => $c ){{ explode('.',$c['descripcion'])[0]}}, @endforeach de la Ley Nacional del Sistema Integral de Justicia Penal para Adolescentes;  &nbsp;
        @endif
        
        lo anterior, se hace  de su conocimiento con la finalidad de que la(s) citada(s) persona(s) imputada(s), tendr??(n) que sujetarse al plan de seguimiento que se elabore 
        en la Unidad de Supervisi??n de Medidas Cautelares y Suspensi??n Condicional del Proceso, en t??rminos del art??culo 
        

        @if($materia_carpeta=='adultos')
         &nbsp; 177 del Ordenamiento adjetivo citado.
        @elseif( $materia_carpeta == 'adolescentes')
         &nbsp; 124 de la Ley Nacional del Sistema Integral de Justicia Penal para Adolescentes y 177 del C??digo Nacional de Procedimientos Penales. 
        @endif
        <br><br>

        Finalmente, le informo que la persona imputada citada, fue notificada de la(s) condici??n(es) que le(s) fue(ron) impuesta(s), as?? como de la 
        <span style="text-decoration: underline black; font-weight: bold">obligaci??n de presentarse {{$obligacion_presentarse_usmc}}</span><span> ante la Unidad a su digno cargo, ubicada en </span><span style="font-weight: bold">calle Claudio 
        Bernard, n??mero 60, planta baja, colonia Doctores, Alcald??a Cuauht??moc, Ciudad de M??xico</span>, en un horario de lunes a viernes de 9:00 a 18:00 horas, @if($materia_carpeta=='adultos') &nbsp;as?? como s??bado, domingo y d??as festivos de 10:00 a 16:00 horas,&nbsp;@endif 
        <span style="font-weight: bold">CON IDENTIFICACI??N OFICIAL CON FOTOGRAF??A Y COMPROBANTE DE DOMICILIO</span>.
        <br><br>
        Sin otro particular, le reitero la seguridad de mi atenta y distinguida consideraci??n.
      </p>
      
      <p style="text-align: center;font-weight:bold;">
        ATENTAMENTE 
        <br>Juez del Sistema Procesal Penal Acusatorio en 
        <br>la Ciudad de M??xico
        <br><br>
        <br>{{$remitente['titulo']}}. {{$remitente['nombre_mayuscula']}}
      </p>

      <br><br><br>

      <p style="font-size:10px;text-align: justify;">
        <span style="font-weight:bold;">C.c.p. Imputado </span> @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['nombre_completo_mayuscula']}}. </span> @endforeach
      </p>

    @elseif($plantilla==532) {{--Medida Cautelar dentro del plazo constitucional--}}
    
      <p style="text-align:justify;">
        Le comunico que en <span style="font-weight:bold;">Audiencia Inicial</span> del d??a {{$audiencia['fecha_inicio_letra']}}, presidida por el (la) <span style="font-weight:bold;text-decoration: underline black;">{{$juez_control['titulo']}} {{$juez_control['nombre_completo']}}</span>, Juez(a) 
        de Control del Sistema Procesal Penal Acusatorio de la Ciudad de M??xico, respecto de la carpeta judicial citada al rubro, instruida en contra de 
        la persona imputada @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['nombre_completo_mayuscula']}}, </span> @endforeach se determin?? procedente <span style="font-weight:bold;">CALIFICAR DE LEGAL LA DETENCI??N </span>
        por la probable comisi??n del (los) hecho(s) que la ley establece como delito(s) de @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['delitos_mayuscula']}}, </span> @endforeach cometido(s) en agravio de la(s) v??ctima(s) {{$victimas}},
        y tomando en consideraci??n que la persona imputada citada, solicit?? que su situaci??n jur??dica se resolviera dentro del t??rmino constitucional de {{$tiempo_resolucion_situacion_juridica}} horas, se le impuso la(s) <span style="font-weight:normal;">MEDIDA(S) CAUTELAR(ES)</span> establecida(s) 
        
        @if($materia_carpeta=='adultos')
          <span style="font-weight:normal;"> en el art??culo 155 fracci??n(es) </span> @foreach($medidas_cautelares as $index => $mc ){{ explode('.',$mc['descripcion'])[0]}} , @endforeach del C??digo Nacional de Procedimientos Penales consistente(s) en:
        @elseif( $materia_carpeta == 'adolescentes')
          <span style="font-weight:normal;"> en el art??culo 119 fracci??n(es) </span> @foreach($medidas_cautelares as $index => $mc ){{ explode('.',$mc['descripcion'])[0]}} , @endforeach consistente(s) en:
        @endif

        <br><br>
        @foreach($medidas_cautelares as $index => $medidas_cautelares )
        {{$medidas_cautelares['descripcion']}} {{-- $medidas_cautelares['detalle_adicional'] --}} {{ strlen($medidas_cautelares['duracion']) ? 'misma que tendr?? una vigencia por '.$medidas_cautelares['duracion'] : '' }}. <br>
        @endforeach
        <br><br>

        Medida(s) Cautelar(es) que le(s) fue(ron) impuesta(s) atento al principio de proporcionalidad e idoneidad, cuya duraci??n ser?? por todo el tiempo 
        que dure el procedimiento penal; lo anterior, se hace de su conocimiento con la finalidad de que la(s) citada(s) persona(s) imputada(s) se 
        sujete(n) al plan de seguimiento que se elabore en la Unidad de Supervisi??n de Medidas Cautelares y Suspensi??n Condicional del Proceso, 
        en t??rminos de lo dispuesto por el art??culo 

        @if($materia_carpeta=='adultos')
          &nbsp;177 del Ordenamiento adjetivo citado.
        @elseif( $materia_carpeta == 'adolescentes')
          &nbsp;124 de la de la Ley Nacional del Sistema Integral de Justicia Penal para Adolescentes y 177 del C??digo Nacional de Procedimientos Penales.
        @endif
        
         

        <br><br>

        Finalmente, le informo que <span style="font-weight:bold;"> la persona imputada citada,</span><span> fue notificada de la(s) medida(s) cautelar(es) impuesta(s), as?? como de la</span> 
        <span style="text-decoration: underline black; font-weight: bold">obligaci??n de presentarse {{$obligacion_presentarse_usmc}}</span><span> ante la Unidad a su digno cargo, ubicada en </span><span style="font-weight: bold">calle Claudio 
        Bernard, n??mero 60, planta baja, colonia Doctores, Alcald??a Cuauht??moc, Ciudad de M??xico</span>, en un horario de lunes a viernes de 9:00 a 18:00 horas, 
        
        @if($materia_carpeta=='adultos')
          &nbsp;as?? como s??bado, domingo y d??as festivos de 10:00 a 16:00 horas, 
        @endif 
        
        <span style="font-weight: bold">CON IDENTIFICACI??N OFICIAL CON FOTOGRAF??A Y COMPROBANTE DE DOMICILIO</span>.
        <br><br>
        Sin otro particular, le reitero la seguridad de mi atenta y distinguida consideraci??n.
      </p>
      
      <p style="text-align: center;font-weight:bold;">
        ATENTAMENTE 
        <br>Juez del Sistema Procesal Penal Acusatorio en 
        <br>la Ciudad de M??xico
        <br><br>
        <br>{{$remitente['titulo']}}. {{$remitente['nombre_mayuscula']}}
      </p>

      <br><br><br>

      <p style="font-size:10px;text-align: justify;">
        <span style="font-weight:bold;">C.c.p. Imputado </span> @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['nombre_completo_mayuscula']}}. </span> @endforeach
      </p>
    @elseif($plantilla==533) {{-- suspension condicional y Medida Cautelar--}}
    
      <p style="text-align:justify;">
        Hago de su conocimiento que el d??a {{$audiencia['fecha_inicio_letra']}} en <span style="font-weight:bold;">Audiencia Inicial</span>, presidida por el (la) <span style="font-weight:bold;text-decoration: underline black;">{{$juez_control['titulo']}} {{$juez_control['nombre_completo']}}</span>, Juez(a) 
        de Control del Sistema Procesal Penal Acusatorio de la Ciudad de M??xico, respecto de la carpeta judicial citada al rubro, instruida en contra de 
        la (s) persona (s) imputada (s) @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['nombre_completo_mayuscula']}}, </span> @endforeach por la probable comisi??n del (los) hecho(s) que la Ley establece como delito(s) de  @foreach($imputados as $imputado) <span style="font-weight:normal;">{{$imputado['delitos_mayuscula']}}, </span> @endforeach 
        cometido(s) en agravio de la(s) v??ctima(s) {{$victimas}}, as?? como autorizar a favor de la (s) persona (s) imputada (s)  @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['nombre_completo_mayuscula']}}, </span> @endforeach la <span style="font-weight:bold; text-transform: uppercase;">Suspensi??n Condicional del Proceso </span>, consistente en:
        <br><br>
        @foreach($condiciones as $index => $c )
          @if( $c['tipo'] = "condicion_suspension_del_proceso" ) 
            {{$c['descripcion']}} {{-- $c['detalle_adicional'] --}} {{ strlen($c['duracion']) ? 'misma que tendr?? una vigencia por '.$c['duracion'] : '' }}. <br>
          @endif
        @endforeach
        <br><br>

        Asimismo, se informa que {{$plan_reparaci??n_danio}}

        <br><br>

        Condici??n(es) que fue(ron) impuesta(s) atento al principio de proporcionalidad e idoneidad, cuya duraci??n ser?? por {{$periodo_suspension}} meses, con fundamento en lo 
        establecido en el art??culo 

        @if($materia_carpeta=='adultos')
         &nbsp; 195 fracci??n(es)  @foreach($condiciones as $index => $c ) @if( $c['tipo'] = "condicion_suspension_del_proceso" ){{ explode('.',$c['descripcion'])[0]}},@endif @endforeach del C??digo Nacional de Procedimientos Penales; &nbsp;
        @elseif( $materia_carpeta == 'adolescentes')
          &nbsp; 102 fracci??n(es)  @foreach($condiciones as $index => $c )@if( $c['tipo'] = "condicion_suspension_del_proceso" ){{ explode('.',$c['descripcion'])[0]}}},@endif @endforeach de la Ley Nacional del Sistema Integral de Justicia Penal para Adolescentes;  &nbsp;
        @endif
        
        lo anterior, se hace  de su conocimiento con la finalidad de que la(s) citada(s) persona(s) imputada(s), tendr??(n) que sujetarse al plan de seguimiento que se elabore 
        en la Unidad de Supervisi??n de Medidas Cautelares y Suspensi??n Condicional del Proceso, en t??rminos del art??culo 
        

        @if($materia_carpeta=='adultos')
         &nbsp; 177 del Ordenamiento adjetivo citado.
        @elseif( $materia_carpeta == 'adolescentes')
         &nbsp; 124 de la Ley Nacional del Sistema Integral de Justicia Penal para Adolescentes y 177 del C??digo Nacional de Procedimientos Penales. 
        @endif
        <br><br>

        Asimismo, se determin?? imponer a la persona imputada @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['nombre_completo_mayuscula']}}, </span> @endforeach la(s) medida(s) cautelar(es) establecida(s) 
        en el articulo 155 fracci??n(es) @foreach($medidas_cautelares as $index => $mc ) {{ explode('.',$mc['descripcion'])[0]}}, @endforeach del C??digo Nacional de Procedimientos Penales, consistente(s) en:  
        <br><br>
        @foreach($medidas_cautelares as $index => $mc )
          {{$mc['descripcion']}} {{-- $mc['detalle_adicional'] --}} {{ strlen($mc['duracion']) ? 'misma que tendr?? una vigencia por '.$mc['duracion'] : '' }}. <br>
        @endforeach
        <br><br>

        Medida(s) Cautelar(es) que le fue(ron) impuesta(s) atento al principio de proporcionalidad e idoneidad, cuya duraci??n ser?? por todo el tiempo que dure el procedimiento penal; lo anterior, se hace de su conocimiento con la finalidad 
        de que la citada persona imputada, se sujete al plan de seguimiento que se elabore en la Unidad de Supervisi??n de Medidas Cautelares y Suspensi??n Condicional del Proceso, en t??rminos de lo dispuesto por el art??culo 177 del Ordenamiento adjetivo citado.

        <br><br>

        Finalmente, le informo que la persona imputada citada, fue notificada de la(s) condici??n(es) que le(s) fue(ron) impuesta(s), as?? como de la 
        <span style="text-decoration: underline black; font-weight: bold">obligaci??n de presentarse {{$obligacion_presentarse_usmc}} </span><span> ante la Unidad a su digno cargo, ubicada en </span><span style="font-weight: bold">calle Claudio 
        Bernard, n??mero 60, planta baja, colonia Doctores, Alcald??a Cuauht??moc, Ciudad de M??xico</span>, en un horario de lunes a viernes de 9:00 a 18:00 horas, @if($materia_carpeta=='adultos') &nbsp;as?? como s??bado, domingo y d??as festivos de 10:00 a 16:00 horas,&nbsp;@endif 
        <span style="font-weight: bold">CON IDENTIFICACI??N OFICIAL CON FOTOGRAF??A Y COMPROBANTE DE DOMICILIO</span>.
        <br><br>
        Sin otro particular, le reitero la seguridad de mi atenta y distinguida consideraci??n.
      </p>
      
      <p style="text-align: center;font-weight:bold;">
        ATENTAMENTE 
        <br>Juez del Sistema Procesal Penal Acusatorio en 
        <br>la Ciudad de M??xico
        <br><br>
        <br>{{$remitente['titulo']}}. {{$remitente['nombre_mayuscula']}}
      </p>

      <br><br><br>

      <p style="font-size:10px;text-align: justify;">
        <span style="font-weight:bold;">C.c.p. Imputado </span> @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['nombre_completo_mayuscula']}}. </span> @endforeach
      </p>

    @elseif($plantilla==503) {{--imposicion medida cautelar--}}
    
      <p style="text-align:justify;">
        Hago de su conocimiento que el d??a {{$audiencia['fecha_inicio_letra']}} en <span style="font-weight:bold;">Audiencia Inicial</span>, presidida por el (la) <span style="font-weight:bold;text-decoration: underline black;">{{$juez_control['titulo']}} {{$juez_control['nombre_completo']}}</span>, Juez(a) 
        de Control del Sistema Procesal Penal Acusatorio de la Ciudad de M??xico, respecto de la carpeta judicial citada al rubro, instruida en contra de 
        la persona imputada @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['nombre_completo_mayuscula']}}, </span> @endforeach determin?? procedente <span style="font-weight:bold;">CALIFICAR DE LEGAL LA DETENCI??N Y VINCULAR A PROCESO </span>
        por la probable comisi??n del (los) hecho(s) que la ley establece como delito(s) de @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['delitos_mayuscula']}}, </span> @endforeach cometido(s) en agravio de la(s) v??ctima(s) {{$victimas}}, as?? como imponer a dicha persona imputada, la(s) <span style="font-weight:normal;">medida(s) cautelar(es)</span> establecida(s) 
        
        @if($materia_carpeta=='adultos')
          <span style="font-weight:normal;"> en el art??culo 155 fracci??n(es) </span> @foreach($medidas_cautelares as $index => $mc ){{ explode('.',$mc['descripcion'])[0]}} , @endforeach del C??digo Nacional de Procedimientos Penales consistente(s) en:
        @elseif( $materia_carpeta == 'adolescentes')
          <span style="font-weight:normal;"> en el art??culo 119 fracci??n(es) </span> @foreach($medidas_cautelares as $index => $mc ){{ explode('.',$mc['descripcion'])[0]}} , @endforeach consistente(s) en:
        @endif
        
        
        <br><br>
        @foreach($medidas_cautelares as $index => $medidas_cautelares )
        {{$medidas_cautelares['descripcion']}} {{-- $medidas_cautelares['detalle_adicional'] --}} {{ strlen($medidas_cautelares['duracion']) ? 'misma que tendr?? una vigencia por '.$medidas_cautelares['duracion'] : '' }}. <br>
        @endforeach
        <br><br>

        Medida(s) Cautelar(es) que le(s) fue(ron) impuesta(s) atento al principio de proporcionalidad e idoneidad, cuya duraci??n ser?? por todo el tiempo 
        que dure el procedimiento penal; lo anterior, se hace de su conocimiento con la finalidad de que la(s) citada(s) persona(s) imputada(s) se 
        sujete(n) al plan de seguimiento que se elabore en la Unidad de Supervisi??n de Medidas Cautelares y Suspensi??n Condicional del Proceso, 
        en t??rminos de lo dispuesto por el art??culo 

        @if($materia_carpeta=='adultos')
          &nbsp; 177 del Ordenamiento adjetivo citado.
        @elseif( $materia_carpeta == 'adolescentes')
          &nbsp; 124 de la de la Ley Nacional del Sistema Integral de Justicia Penal para Adolescentes y 177 del C??digo Nacional de Procedimientos Penales.
        @endif
        <br><br>

        Finalmente, le informo que <span style="font-weight:bold;"> la persona imputada citada,</span> <span>fue notificada de la(s) medida(s) cautelar(es) impuesta(s), as?? como de la</span> 
        <span style="text-decoration: underline black; font-weight: bold">obligaci??n de presentarse {{$obligacion_presentarse_usmc}}</span><span> ante esa Unidad a su digno cargo, ubicada en </span><span style="font-weight: bold">calle Claudio 
        Bernard, n??mero 60, planta baja, colonia Doctores, Alcald??a Cuauht??moc, Ciudad de M??xico</span>, en un horario de lunes a viernes de 9:00 a 18:00 horas, 
        
        @if($materia_carpeta=='adultos')
          &nbsp; as?? como s??bado, domingo y d??as festivos de 10:00 a 16:00 horas, 
        @endif
        
        <span style="font-weight: bold">CON IDENTIFICACI??N OFICIAL CON FOTOGRAF??A Y COMPROBANTE DE DOMICILIO</span>.
        <br><br>
        Sin otro particular, le reitero la seguridad de mi atenta y distinguida consideraci??n.
      </p>
      
      <p style="text-align: center;font-weight:bold;">
        ATENTAMENTE 
        <br>Juez del Sistema Procesal Penal Acusatorio en 
        <br>la Ciudad de M??xico
        <br><br>
        <br>{{$remitente['titulo']}}. {{$remitente['nombre_mayuscula']}}
      </p>

      <br><br><br>

      <p style="font-size:10px;text-align: justify;">
        <span style="font-weight:bold;">C.c.p. Imputado </span> @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['nombre_completo_mayuscula']}}. </span> @endforeach
      </p>

    @elseif($plantilla==513) {{--sobreseimiento--}}
    
      <p style="text-align:justify;">
        En cumplimiento a lo ordenado por el <span style="font-weight:bold;text-decoration: underline black;">{{$juez_control['titulo']}} {{$juez_control['nombre_mayuscula']}}</span>, {{$juez_control['descripcion']}} del 
        Sistema Procesal Penal Acusatorio de la Ciudad de M??xico, le comunico que, dicho Juzgador, 
        el d??a de la fecha presidi?? continuaci??n de <span style="text-transform: uppercase;">{{$audiencia['tipo_audiencia']}}</span>, dentro de la 
        carpeta judicial se??alada al rubro, instruida en contra del imputado @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['nombre_completo_mayuscula']}}, </span> @endforeach 
        por el hecho que la ley se??ala como el delito de @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['delitos_mayuscula']}}, </span> @endforeach
        por lo que al manifestar la v??ctima <span style="text-transform: uppercase;font-weight:bold;">{{$victimas}}</span>, que estaba de 
        acuerdo en que se efectuara dicha soluci??n alterna, el juzgador autoriz?? a favor del imputado 
        @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['nombre_completo_mayuscula']}}, </span> @endforeach el Acuerdo Reparatorio, mismo que fue de cumplimiento 
        inmediato, declar??ndose <span style="font-weight:bold;">la extinci??n de la acci??n penal y el sobreseimiento total del asunto, con 
        efectos de sentencia absolutoria, quedando firme dicha resoluci??n.</span>
        <br><br>
        Atento a lo anterior, hago de su conocimiento que, en la citada audiencia, se dej?? sin efectos la 
        medida cautelar que le fue impuesta al imputado de referencia, en audiencia inicial, con fecha {{$audienciamc['fecha_inicio_letra']}}, 
        la cual se le hizo de su conocimiento a usted, mediante el oficio n??mero {{$numero_oficio_mc}}, 
        consistente en presentaci??n peri??dica mensual; asimismo le informo que en fecha __________________, el imputado de m??rito, 
        fue vinculado a proceso.
        <br>
        <br>
        Lo que comunico a Usted, para los fines que a su competencia correspondan, y aprovechando para enviarle un cordial saludo.
      </p>
      <br>
      <p style="text-align: center;font-weight:bold;">
        ATENTAMENTE 
        <br>{{$remitente['puesto_mayuscula']}}
        <br><br><br>
        <br>{{$remitente['titulo']}}. {{$remitente['nombre_mayuscula']}}
      </p>
    @elseif($plantilla==504) {{--audiencia y solucion alterna--}}
      <p style="text-align:justify;">
        Por el presente le informo que, en la sede de esta Unidad de Gesti??n Judicial Uno, 
        <span style="font-weight:bold;">el {{$audiencia['fecha_inicio_letra']}} a las {{$audiencia['hora_inicio_letra']}} horas, se celebrar?? {{$audiencia['tipo_audiencia']}},</span> en contra del imputado: @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['nombre_completo_mayuscula']}}, </span> @endforeach 
        relacionado con la carpeta judicial citada al rubro.
        <br><br>
        Ahora bien, con la finalidad de que el Juez que presidir?? tal diligencia, en t??rminos de lo dispuesto 
        por los numerales 183 y 192 del C??digo Nacional de Procedimientos Penales, <span style="font-weight:bold;">tenga conocimiento del registro de suspensiones condicionales a proceso</span>
        que en su caso hubiere celebrado el imputado aludido,
        <span style="text-decoration: underline black;font-weight:bold;">le solicito de manera URGENTE, me informe si en su base de datos cuenta con alg??n registro de que el imputado celebrado alguna SUSPENSI??N CONDICIONAL DEL PROCESO;</span>
        <span style="font-weight:bold;">en el entendido que de ser afirmativo esto, deber?? informar el estado actual de dicha soluci??n alterna.</span>
        <br><br>
        Sin m??s por el momento, reitero a Usted la seguridad de mi atenta consideraci??n.
      </p>
      <br>
      <p style="text-align: center;font-weight:bold;">
        ATENTAMENTE 
        <br>{{$remitente['puesto_mayuscula']}}
        <br><br><br>
        <br>{{$remitente['titulo']}}. {{$remitente['nombre_mayuscula']}}
      </p>
    @else
      <p style="text-align:center;">[ contenido ]</p>
    @endif

    @if($plantilla!=501) {{-- PIE DE PAGINA PARA TODO FORMATO EXCEPTO EL GENERAL --}}
      <p style="font-size:10px;text-align: center;font-weight:bold;">
        UNIDAD DE GESTI??N JUDICIAL {{$numero_ugj}} DEL SISTEMA PROCESAL PENAL ACUSATORIO <br>
        {{$direccion}} [TELEFONOS] en un horario de atenci??n de lunes a jueves de {{$horario_apertura}} a {{$horario_cierre_lj}} hrs. y viernes de {{$horario_apertura}} a {{$horario_cierre_v}} hrs.
      </p>
    @endif

  {{-- </div>
</div> --}}

