 
 
        <table class="configTableCabecera">
            <tr>
                <th align="left" width="40px" ROWSPAN=3>
                <!-- <img src="{{public_path('img/LogoCompleto.png') }}" borde="0" width="102px" height="50px" /> -->
                </th>
                <th align="center"><span> Benemerita Sociedad Protectora de la Infancia</span></th>
            </tr>
            <tr>
                <th align="center"><span>Club Rotario Astillero</span></th>
            </tr>
            <tr>
                <th align="center"><span>GUAYAQUIL</span></th>
            </tr>

        </table>
 
    
 
<table class="configTableCaberaAll configBorderItem configTextItem2 topCabecera" >
    <tr class="cabeceras" >
        <td>Nº registro</td>
        <td>Fecha de registro</td>
        <td>Descripcion de Desechos</td>
        <td>Responsable del área</td>
        <td>Departamento</td>
         
        <td>Kg.</td>
        
        
    </tr>
    @php
    $cont = 0;
    @endphp
    @for($i=0; $i < sizeof($lista) ; $i++) <tr>
        @php
        $cont = $i;
        $cont +=1;

        @endphp
        <td   > {{$cont}}</td>
        <td > {{ $lista[$i]->created_at }}</td>
               <td > {{ $lista[$i]->des_clasificacion_desechos_des  }}</td>
        <td > {{ $lista[$i]->responsable_apellido  }} {{ $lista[$i]->responsable_nombre  }}</td>
        <td > {{ $lista[$i]->departamento  }}</td>
        
        <td > {{ $lista[$i]->peso  }}</td>
        
       
       
        </tr>

        @endfor


</table>




<table style="position: fixed;bottom: 0px;">
    <thead>
        <tr>
            
        </tr>
    </thead>
</table>


 