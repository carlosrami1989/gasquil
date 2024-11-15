 
  
 
<table class="configTableCaberaAll configBorderItem configTextItem2 topCabecera" >
    <tr class="cabeceras" >
        <td>Nº</td>
        <td>ESTACION</td>
        <td>Descripcion</td>
        <td>stock </td>
        <td>facturado </td>
        <td>total </td>
        <td>estado </td>
        
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
        <td > {{ $lista[$i]->des_estacion }}</td>
               <td > {{ $lista[$i]->codigop  }}</td>
        <td > {{ $lista[$i]->stock  }} </td>
        <td > {{ $lista[$i]->facturado  }} </td>
        <td > {{ $lista[$i]->total  }} </td>
        <td > {{ $lista[$i]->estado  }} </td>
       
       
        </tr>

        @endfor


</table>




<table style="position: fixed;bottom: 0px;">
    <thead>
        <tr>
            
        </tr>
    </thead>
</table>


 