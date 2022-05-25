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
      <p style="text-align:right;">Ciudad de México a {{$fecha_oficio}}
        <br> <span style="font-weight:bold;"> Carpeta Judicial: {{$carpeta_judicial}}</span>
        <br> <span style="font-weight:bold;"> Carpeta de Investigación: {{$carpeta_investigacion}}</span>
        <br> <span style="font-weight:bold;"> Imputado: @foreach($imputados as $imputado) {{$imputado['nombre_completo_mayuscula']}}. </span> @endforeach
        <br> <span style="font-weight:bold;"> Víctima u Ofendido: {{$victimas}}</span>
        <br> <span style="font-weight:bold;"> Hechos con apariencia de delito: @foreach($imputados as $imputado) {{$imputado['delitos_mayuscula']}}. </span> @endforeach
        <br> <span style="font-weight:bold;"> Fecha de vinculación a proceso: {{$fecha_vinculacion_proceso}}</span>
        <br> <span style="font-weight:bold;"> Oficio: UGJ{{$numero_ugj}}/{{$numero_oficio}}/{{date('Y')}}</span>
        <br> <span style="font-weight:bold;">Asunto: </span> <span style="font-weight:normal;">{{$asunto}}</span>
      </p>
      <br>
      <p style="text-align:left;font-weight:bold;">DIRECTOR EJECUTIVO DE LA UNIDAD DE
        <br>SUPERVISIÓN DE MEDIDAS CAUTELARES Y
        <br>SUSPENSIÓN CONDICIONAL DEL PROCESO.         
        <br><br>PRESENTE.
      </p>
    @endif
    
    @if($plantilla==41) {{--suspencion condicional proceso--}}
    
      <p style="text-align:justify;">
        Hago de su conocimiento que el día {{$audiencia['fecha_inicio_letra']}} en <span style="font-weight:bold;">Audiencia Inicial</span>, presidida por el (la) <span style="font-weight:bold;text-decoration: underline black;">{{$juez_control['titulo']}} {{$juez_control['nombre_completo']}}</span>, Juez(a) 
        de Control del Sistema Procesal Penal Acusatorio de la Ciudad de México, respecto de la carpeta judicial citada al rubro, instruida en contra de 
        la persona imputada @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['nombre_completo_mayuscula']}}, </span> @endforeach determinó <span style="font-weight:bold;"> calificar de legal su detención, vinculándola a proceso </span> por el
        (los) hecho(s) que la ley señala como delito(s) de @foreach($imputados as $imputado) <span style="font-weight:normal;">{{$imputado['delitos_mayuscula']}}, </span> @endforeach cometido(s) en agravio de {{$victimas}}, concediendo la Suspensión Condicional del Proceso, consistente(s) en:
        <br><br>
        @foreach($condiciones as $index => $c )
        {{$c['descripcion']}} {{-- $c['detalle_adicional'] --}} {{ strlen($c['duracion']) ? 'misma que tendrá una vigencia por '.$c['duracion'] : '' }}. <br>
        @endforeach
        <br><br>

        Asimismo, autorizó el plan de reparación del daño consistente en: {{$plan_reparación_danio}}

        <br><br>

        Condición(es) que fue(ron) impuesta(s) atento al principio de proporcionalidad e idoneidad, cuya duración será por {{$periodo_suspension}} meses, con fundamento en lo 
        establecido en el artículo 

        @if($materia_carpeta=='adultos')
         &nbsp; 195 fracción(es)  @foreach($condiciones as $index => $c ){{ explode('.',$c['descripcion'])[0]}}, @endforeach del Código Nacional de Procedimientos Penales; &nbsp;
        @elseif( $materia_carpeta == 'adolescentes')
          &nbsp; 102 fracción(es)  @foreach($condiciones as $index => $c ){{ explode('.',$c['descripcion'])[0]}}, @endforeach de la Ley Nacional del Sistema Integral de Justicia Penal para Adolescentes;  &nbsp;
        @endif
        
        lo anterior, se hace  de su conocimiento con la finalidad de que la(s) citada(s) persona(s) imputada(s), tendrá(n) que sujetarse al plan de seguimiento que se elabore 
        en la Unidad de Supervisión de Medidas Cautelares y Suspensión Condicional del Proceso, en términos del artículo 
        

        @if($materia_carpeta=='adultos')
         &nbsp; 177 del Ordenamiento adjetivo citado.
        @elseif( $materia_carpeta == 'adolescentes')
         &nbsp; 124 de la Ley Nacional del Sistema Integral de Justicia Penal para Adolescentes y 177 del Código Nacional de Procedimientos Penales. 
        @endif
        <br><br>

        Finalmente, le informo que la persona imputada citada, fue notificada de la(s) condición(es) que le(s) fue(ron) impuesta(s), así como de la 
        <span style="text-decoration: underline black; font-weight: bold">obligación de presentarse {{$obligacion_presentarse_usmc}}</span><span> ante la Unidad a su digno cargo, ubicada en </span><span style="font-weight: bold">calle Claudio 
        Bernard, número 60, planta baja, colonia Doctores, Alcaldía Cuauhtémoc, Ciudad de México</span>, en un horario de lunes a viernes de 9:00 a 18:00 horas, @if($materia_carpeta=='adultos') &nbsp;así como sábado, domingo y días festivos de 10:00 a 16:00 horas,&nbsp;@endif 
        <span style="font-weight: bold">CON IDENTIFICACIÓN OFICIAL CON FOTOGRAFÍA Y COMPROBANTE DE DOMICILIO</span>.
        <br><br>
        Sin otro particular, le reitero la seguridad de mi atenta y distinguida consideración.
      </p>
      
      <p style="text-align: center;font-weight:bold;">
        ATENTAMENTE 
        <br>Juez del Sistema Procesal Penal Acusatorio en 
        <br>la Ciudad de México
        <br><br>
        <br>{{$remitente['titulo']}}. {{$remitente['nombre_mayuscula']}}
      </p>

      <br><br><br>

      <p style="font-size:10px;text-align: justify;">
        <span style="font-weight:bold;">C.c.p. Imputado </span> @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['nombre_completo_mayuscula']}}. </span> @endforeach
      </p>

    @elseif($plantilla==532) {{--Medida Cautelar dentro del plazo constitucional--}}
    
      <p style="text-align:justify;">
        Le comunico que en <span style="font-weight:bold;">Audiencia Inicial</span> del día {{$audiencia['fecha_inicio_letra']}}, presidida por el (la) <span style="font-weight:bold;text-decoration: underline black;">{{$juez_control['titulo']}} {{$juez_control['nombre_completo']}}</span>, Juez(a) 
        de Control del Sistema Procesal Penal Acusatorio de la Ciudad de México, respecto de la carpeta judicial citada al rubro, instruida en contra de 
        la persona imputada @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['nombre_completo_mayuscula']}}, </span> @endforeach se determinó procedente <span style="font-weight:bold;">CALIFICAR DE LEGAL LA DETENCIÓN </span>
        por la probable comisión del (los) hecho(s) que la ley establece como delito(s) de @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['delitos_mayuscula']}}, </span> @endforeach cometido(s) en agravio de la(s) víctima(s) {{$victimas}},
        y tomando en consideración que la persona imputada citada, solicitó que su situación jurídica se resolviera dentro del término constitucional de {{$tiempo_resolucion_situacion_juridica}} horas, se le impuso la(s) <span style="font-weight:normal;">MEDIDA(S) CAUTELAR(ES)</span> establecida(s) 
        
        @if($materia_carpeta=='adultos')
          <span style="font-weight:normal;"> en el artículo 155 fracción(es) </span> @foreach($medidas_cautelares as $index => $mc ){{ explode('.',$mc['descripcion'])[0]}} , @endforeach del Código Nacional de Procedimientos Penales consistente(s) en:
        @elseif( $materia_carpeta == 'adolescentes')
          <span style="font-weight:normal;"> en el artículo 119 fracción(es) </span> @foreach($medidas_cautelares as $index => $mc ){{ explode('.',$mc['descripcion'])[0]}} , @endforeach consistente(s) en:
        @endif

        <br><br>
        @foreach($medidas_cautelares as $index => $medidas_cautelares )
        {{$medidas_cautelares['descripcion']}} {{-- $medidas_cautelares['detalle_adicional'] --}} {{ strlen($medidas_cautelares['duracion']) ? 'misma que tendrá una vigencia por '.$medidas_cautelares['duracion'] : '' }}. <br>
        @endforeach
        <br><br>

        Medida(s) Cautelar(es) que le(s) fue(ron) impuesta(s) atento al principio de proporcionalidad e idoneidad, cuya duración será por todo el tiempo 
        que dure el procedimiento penal; lo anterior, se hace de su conocimiento con la finalidad de que la(s) citada(s) persona(s) imputada(s) se 
        sujete(n) al plan de seguimiento que se elabore en la Unidad de Supervisión de Medidas Cautelares y Suspensión Condicional del Proceso, 
        en términos de lo dispuesto por el artículo 

        @if($materia_carpeta=='adultos')
          &nbsp;177 del Ordenamiento adjetivo citado.
        @elseif( $materia_carpeta == 'adolescentes')
          &nbsp;124 de la de la Ley Nacional del Sistema Integral de Justicia Penal para Adolescentes y 177 del Código Nacional de Procedimientos Penales.
        @endif
        
         

        <br><br>

        Finalmente, le informo que <span style="font-weight:bold;"> la persona imputada citada,</span><span> fue notificada de la(s) medida(s) cautelar(es) impuesta(s), así como de la</span> 
        <span style="text-decoration: underline black; font-weight: bold">obligación de presentarse {{$obligacion_presentarse_usmc}}</span><span> ante la Unidad a su digno cargo, ubicada en </span><span style="font-weight: bold">calle Claudio 
        Bernard, número 60, planta baja, colonia Doctores, Alcaldía Cuauhtémoc, Ciudad de México</span>, en un horario de lunes a viernes de 9:00 a 18:00 horas, 
        
        @if($materia_carpeta=='adultos')
          &nbsp;así como sábado, domingo y días festivos de 10:00 a 16:00 horas, 
        @endif 
        
        <span style="font-weight: bold">CON IDENTIFICACIÓN OFICIAL CON FOTOGRAFÍA Y COMPROBANTE DE DOMICILIO</span>.
        <br><br>
        Sin otro particular, le reitero la seguridad de mi atenta y distinguida consideración.
      </p>
      
      <p style="text-align: center;font-weight:bold;">
        ATENTAMENTE 
        <br>Juez del Sistema Procesal Penal Acusatorio en 
        <br>la Ciudad de México
        <br><br>
        <br>{{$remitente['titulo']}}. {{$remitente['nombre_mayuscula']}}
      </p>

      <br><br><br>

      <p style="font-size:10px;text-align: justify;">
        <span style="font-weight:bold;">C.c.p. Imputado </span> @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['nombre_completo_mayuscula']}}. </span> @endforeach
      </p>
    @elseif($plantilla==533) {{-- suspension condicional y Medida Cautelar--}}
    
      <p style="text-align:justify;">
        Hago de su conocimiento que el día {{$audiencia['fecha_inicio_letra']}} en <span style="font-weight:bold;">Audiencia Inicial</span>, presidida por el (la) <span style="font-weight:bold;text-decoration: underline black;">{{$juez_control['titulo']}} {{$juez_control['nombre_completo']}}</span>, Juez(a) 
        de Control del Sistema Procesal Penal Acusatorio de la Ciudad de México, respecto de la carpeta judicial citada al rubro, instruida en contra de 
        la (s) persona (s) imputada (s) @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['nombre_completo_mayuscula']}}, </span> @endforeach por la probable comisión del (los) hecho(s) que la Ley establece como delito(s) de  @foreach($imputados as $imputado) <span style="font-weight:normal;">{{$imputado['delitos_mayuscula']}}, </span> @endforeach 
        cometido(s) en agravio de la(s) víctima(s) {{$victimas}}, así como autorizar a favor de la (s) persona (s) imputada (s)  @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['nombre_completo_mayuscula']}}, </span> @endforeach la <span style="font-weight:bold; text-transform: uppercase;">Suspensión Condicional del Proceso </span>, consistente en:
        <br><br>
        @foreach($condiciones as $index => $c )
          @if( $c['tipo'] = "condicion_suspension_del_proceso" ) 
            {{$c['descripcion']}} {{-- $c['detalle_adicional'] --}} {{ strlen($c['duracion']) ? 'misma que tendrá una vigencia por '.$c['duracion'] : '' }}. <br>
          @endif
        @endforeach
        <br><br>

        Asimismo, se informa que {{$plan_reparación_danio}}

        <br><br>

        Condición(es) que fue(ron) impuesta(s) atento al principio de proporcionalidad e idoneidad, cuya duración será por {{$periodo_suspension}} meses, con fundamento en lo 
        establecido en el artículo 

        @if($materia_carpeta=='adultos')
         &nbsp; 195 fracción(es)  @foreach($condiciones as $index => $c ) @if( $c['tipo'] = "condicion_suspension_del_proceso" ){{ explode('.',$c['descripcion'])[0]}},@endif @endforeach del Código Nacional de Procedimientos Penales; &nbsp;
        @elseif( $materia_carpeta == 'adolescentes')
          &nbsp; 102 fracción(es)  @foreach($condiciones as $index => $c )@if( $c['tipo'] = "condicion_suspension_del_proceso" ){{ explode('.',$c['descripcion'])[0]}}},@endif @endforeach de la Ley Nacional del Sistema Integral de Justicia Penal para Adolescentes;  &nbsp;
        @endif
        
        lo anterior, se hace  de su conocimiento con la finalidad de que la(s) citada(s) persona(s) imputada(s), tendrá(n) que sujetarse al plan de seguimiento que se elabore 
        en la Unidad de Supervisión de Medidas Cautelares y Suspensión Condicional del Proceso, en términos del artículo 
        

        @if($materia_carpeta=='adultos')
         &nbsp; 177 del Ordenamiento adjetivo citado.
        @elseif( $materia_carpeta == 'adolescentes')
         &nbsp; 124 de la Ley Nacional del Sistema Integral de Justicia Penal para Adolescentes y 177 del Código Nacional de Procedimientos Penales. 
        @endif
        <br><br>

        Asimismo, se determinó imponer a la persona imputada @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['nombre_completo_mayuscula']}}, </span> @endforeach la(s) medida(s) cautelar(es) establecida(s) 
        en el articulo 155 fracción(es) @foreach($medidas_cautelares as $index => $mc ) {{ explode('.',$mc['descripcion'])[0]}}, @endforeach del Código Nacional de Procedimientos Penales, consistente(s) en:  
        <br><br>
        @foreach($medidas_cautelares as $index => $mc )
          {{$mc['descripcion']}} {{-- $mc['detalle_adicional'] --}} {{ strlen($mc['duracion']) ? 'misma que tendrá una vigencia por '.$mc['duracion'] : '' }}. <br>
        @endforeach
        <br><br>

        Medida(s) Cautelar(es) que le fue(ron) impuesta(s) atento al principio de proporcionalidad e idoneidad, cuya duración será por todo el tiempo que dure el procedimiento penal; lo anterior, se hace de su conocimiento con la finalidad 
        de que la citada persona imputada, se sujete al plan de seguimiento que se elabore en la Unidad de Supervisión de Medidas Cautelares y Suspensión Condicional del Proceso, en términos de lo dispuesto por el artículo 177 del Ordenamiento adjetivo citado.

        <br><br>

        Finalmente, le informo que la persona imputada citada, fue notificada de la(s) condición(es) que le(s) fue(ron) impuesta(s), así como de la 
        <span style="text-decoration: underline black; font-weight: bold">obligación de presentarse {{$obligacion_presentarse_usmc}} </span><span> ante la Unidad a su digno cargo, ubicada en </span><span style="font-weight: bold">calle Claudio 
        Bernard, número 60, planta baja, colonia Doctores, Alcaldía Cuauhtémoc, Ciudad de México</span>, en un horario de lunes a viernes de 9:00 a 18:00 horas, @if($materia_carpeta=='adultos') &nbsp;así como sábado, domingo y días festivos de 10:00 a 16:00 horas,&nbsp;@endif 
        <span style="font-weight: bold">CON IDENTIFICACIÓN OFICIAL CON FOTOGRAFÍA Y COMPROBANTE DE DOMICILIO</span>.
        <br><br>
        Sin otro particular, le reitero la seguridad de mi atenta y distinguida consideración.
      </p>
      
      <p style="text-align: center;font-weight:bold;">
        ATENTAMENTE 
        <br>Juez del Sistema Procesal Penal Acusatorio en 
        <br>la Ciudad de México
        <br><br>
        <br>{{$remitente['titulo']}}. {{$remitente['nombre_mayuscula']}}
      </p>

      <br><br><br>

      <p style="font-size:10px;text-align: justify;">
        <span style="font-weight:bold;">C.c.p. Imputado </span> @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['nombre_completo_mayuscula']}}. </span> @endforeach
      </p>

    @elseif($plantilla==503) {{--imposicion medida cautelar--}}
    
      <p style="text-align:justify;">
        Hago de su conocimiento que el día {{$audiencia['fecha_inicio_letra']}} en <span style="font-weight:bold;">Audiencia Inicial</span>, presidida por el (la) <span style="font-weight:bold;text-decoration: underline black;">{{$juez_control['titulo']}} {{$juez_control['nombre_completo']}}</span>, Juez(a) 
        de Control del Sistema Procesal Penal Acusatorio de la Ciudad de México, respecto de la carpeta judicial citada al rubro, instruida en contra de 
        la persona imputada @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['nombre_completo_mayuscula']}}, </span> @endforeach determinó procedente <span style="font-weight:bold;">CALIFICAR DE LEGAL LA DETENCIÓN Y VINCULAR A PROCESO </span>
        por la probable comisión del (los) hecho(s) que la ley establece como delito(s) de @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['delitos_mayuscula']}}, </span> @endforeach cometido(s) en agravio de la(s) víctima(s) {{$victimas}}, así como imponer a dicha persona imputada, la(s) <span style="font-weight:normal;">medida(s) cautelar(es)</span> establecida(s) 
        
        @if($materia_carpeta=='adultos')
          <span style="font-weight:normal;"> en el artículo 155 fracción(es) </span> @foreach($medidas_cautelares as $index => $mc ){{ explode('.',$mc['descripcion'])[0]}} , @endforeach del Código Nacional de Procedimientos Penales consistente(s) en:
        @elseif( $materia_carpeta == 'adolescentes')
          <span style="font-weight:normal;"> en el artículo 119 fracción(es) </span> @foreach($medidas_cautelares as $index => $mc ){{ explode('.',$mc['descripcion'])[0]}} , @endforeach consistente(s) en:
        @endif
        
        
        <br><br>
        @foreach($medidas_cautelares as $index => $medidas_cautelares )
        {{$medidas_cautelares['descripcion']}} {{-- $medidas_cautelares['detalle_adicional'] --}} {{ strlen($medidas_cautelares['duracion']) ? 'misma que tendrá una vigencia por '.$medidas_cautelares['duracion'] : '' }}. <br>
        @endforeach
        <br><br>

        Medida(s) Cautelar(es) que le(s) fue(ron) impuesta(s) atento al principio de proporcionalidad e idoneidad, cuya duración será por todo el tiempo 
        que dure el procedimiento penal; lo anterior, se hace de su conocimiento con la finalidad de que la(s) citada(s) persona(s) imputada(s) se 
        sujete(n) al plan de seguimiento que se elabore en la Unidad de Supervisión de Medidas Cautelares y Suspensión Condicional del Proceso, 
        en términos de lo dispuesto por el artículo 

        @if($materia_carpeta=='adultos')
          &nbsp; 177 del Ordenamiento adjetivo citado.
        @elseif( $materia_carpeta == 'adolescentes')
          &nbsp; 124 de la de la Ley Nacional del Sistema Integral de Justicia Penal para Adolescentes y 177 del Código Nacional de Procedimientos Penales.
        @endif
        <br><br>

        Finalmente, le informo que <span style="font-weight:bold;"> la persona imputada citada,</span> <span>fue notificada de la(s) medida(s) cautelar(es) impuesta(s), así como de la</span> 
        <span style="text-decoration: underline black; font-weight: bold">obligación de presentarse {{$obligacion_presentarse_usmc}}</span><span> ante esa Unidad a su digno cargo, ubicada en </span><span style="font-weight: bold">calle Claudio 
        Bernard, número 60, planta baja, colonia Doctores, Alcaldía Cuauhtémoc, Ciudad de México</span>, en un horario de lunes a viernes de 9:00 a 18:00 horas, 
        
        @if($materia_carpeta=='adultos')
          &nbsp; así como sábado, domingo y días festivos de 10:00 a 16:00 horas, 
        @endif
        
        <span style="font-weight: bold">CON IDENTIFICACIÓN OFICIAL CON FOTOGRAFÍA Y COMPROBANTE DE DOMICILIO</span>.
        <br><br>
        Sin otro particular, le reitero la seguridad de mi atenta y distinguida consideración.
      </p>
      
      <p style="text-align: center;font-weight:bold;">
        ATENTAMENTE 
        <br>Juez del Sistema Procesal Penal Acusatorio en 
        <br>la Ciudad de México
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
        Sistema Procesal Penal Acusatorio de la Ciudad de México, le comunico que, dicho Juzgador, 
        el día de la fecha presidió continuación de <span style="text-transform: uppercase;">{{$audiencia['tipo_audiencia']}}</span>, dentro de la 
        carpeta judicial señalada al rubro, instruida en contra del imputado @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['nombre_completo_mayuscula']}}, </span> @endforeach 
        por el hecho que la ley señala como el delito de @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['delitos_mayuscula']}}, </span> @endforeach
        por lo que al manifestar la víctima <span style="text-transform: uppercase;font-weight:bold;">{{$victimas}}</span>, que estaba de 
        acuerdo en que se efectuara dicha solución alterna, el juzgador autorizó a favor del imputado 
        @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['nombre_completo_mayuscula']}}, </span> @endforeach el Acuerdo Reparatorio, mismo que fue de cumplimiento 
        inmediato, declarándose <span style="font-weight:bold;">la extinción de la acción penal y el sobreseimiento total del asunto, con 
        efectos de sentencia absolutoria, quedando firme dicha resolución.</span>
        <br><br>
        Atento a lo anterior, hago de su conocimiento que, en la citada audiencia, se dejó sin efectos la 
        medida cautelar que le fue impuesta al imputado de referencia, en audiencia inicial, con fecha {{$audienciamc['fecha_inicio_letra']}}, 
        la cual se le hizo de su conocimiento a usted, mediante el oficio número {{$numero_oficio_mc}}, 
        consistente en presentación periódica mensual; asimismo le informo que en fecha __________________, el imputado de mérito, 
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
        Por el presente le informo que, en la sede de esta Unidad de Gestión Judicial Uno, 
        <span style="font-weight:bold;">el {{$audiencia['fecha_inicio_letra']}} a las {{$audiencia['hora_inicio_letra']}} horas, se celebrará {{$audiencia['tipo_audiencia']}},</span> en contra del imputado: @foreach($imputados as $imputado) <span style="font-weight:bold;">{{$imputado['nombre_completo_mayuscula']}}, </span> @endforeach 
        relacionado con la carpeta judicial citada al rubro.
        <br><br>
        Ahora bien, con la finalidad de que el Juez que presidirá tal diligencia, en términos de lo dispuesto 
        por los numerales 183 y 192 del Código Nacional de Procedimientos Penales, <span style="font-weight:bold;">tenga conocimiento del registro de suspensiones condicionales a proceso</span>
        que en su caso hubiere celebrado el imputado aludido,
        <span style="text-decoration: underline black;font-weight:bold;">le solicito de manera URGENTE, me informe si en su base de datos cuenta con algún registro de que el imputado celebrado alguna SUSPENSIÓN CONDICIONAL DEL PROCESO;</span>
        <span style="font-weight:bold;">en el entendido que de ser afirmativo esto, deberá informar el estado actual de dicha solución alterna.</span>
        <br><br>
        Sin más por el momento, reitero a Usted la seguridad de mi atenta consideración.
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
        UNIDAD DE GESTIÓN JUDICIAL {{$numero_ugj}} DEL SISTEMA PROCESAL PENAL ACUSATORIO <br>
        {{$direccion}} [TELEFONOS] en un horario de atención de lunes a jueves de {{$horario_apertura}} a {{$horario_cierre_lj}} hrs. y viernes de {{$horario_apertura}} a {{$horario_cierre_v}} hrs.
      </p>
    @endif

  {{-- </div>
</div> --}}

