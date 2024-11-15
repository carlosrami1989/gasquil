 
  
 
<table class="configTableCaberaAll configBorderItem configTextItem2 topCabecera" >
    <tr class="cabeceras" >
        <td>Nº</td>
        <td>ESTACION</td>
        <td>Cliente</td>
        <td>Fecha </td>
        <td>Monto de Dolares</td>
        <td>Numero de Factura</td>
        <td>Vendedor</td>
        <td>DesProducto</td>
        <td>Cantidad</td>
        <td>Precio</td>
        <td>Monto Dolares Des</td>
        <td>Fecha Actualizacion</td>       
        
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
               <td > {{ $lista[$i]->Nombre  }}</td>
        <td > {{ $lista[$i]->Fecha  }} </td>
        <td > {{ $lista[$i]->MontoDolares  }}</td>
        <td > {{ $lista[$i]->numerofactura  }}</td>
        <td > {{ $lista[$i]->Vendedor  }}</td>
        <td > {{ $lista[$i]->DesProducto  }}</td>
        <td > {{ $lista[$i]->Cantidad  }}</td>
        <td > {{ $lista[$i]->Precio  }}</td>
        <td > {{ $lista[$i]->MontoDolaresDes  }}</td>
        <td > {{ $lista[$i]->created_at  }}</td>
       
        </tr>

        @endfor


</table>




<table style="position: fixed;bottom: 0px;">
    <thead>
        <tr>
            
        </tr>
    </thead>
</table>


 