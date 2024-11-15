 
  
 
<table class="configTableCaberaAll configBorderItem configTextItem2 topCabecera" >
    <tr class="cabeceras" >
        <td>Nº</td>
        <td>ESTACION</td>
        <td>DesProducto</td>
        <td>Cantidad</td>
          <td>Monto Dolares Des</td>
     
        
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
        <td > {{ $lista[$i]->DesProducto  }}</td>
      
        <td > {{ $lista[$i]->Total_cantidad  }}</td>
        <td > {{ $lista[$i]->Total_dolares  }}</td>
 
       
        </tr>

        @endfor


</table>




<table style="position: fixed;bottom: 0px;">
    <thead>
        <tr>
            
        </tr>
    </thead>
</table>


 