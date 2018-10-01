<?php
   $request = $_REQUEST['tipo'];
   $body = $_REQUEST['cuerpo'];

   switch ($request) {
      case 'dibujar':
         echo graficar($body);//retorna un mensaje que corresponde a si funciono o no
         break;
      case 'recuperar':
         echo imagen();//retorna imagen en base 64
         break;
      case 'debug':
         echo $body.' hola desde server.php';
         break;
      default:
         echo 'ese codigo no es valido jose';
         break;
   }
   function graficar($codigo64)
   {
      $codigo = base64_decode($codigo64);//nuevo
      $codigo = str_replace('&#60;', '<', $codigo);//nuevo
      $codigo = str_replace('&#62;', '>', $codigo); //nuevo
      $file = 'arbol.txt';
      $handle = fopen($file, 'w') or die ('No se pudo abrir'.$file);
      fwrite($handle, $codigo);
      fclose($handle);
      //generamos la imagen
      $cmd = 'dot -Tpng arbol.txt -o arbol.png 2>&1';
      $salida=shell_exec($cmd);
      if($salida==null)//si cmd no retorno ningun error
         return 'Grafica generada con exito';
      else 
         return 'Lo sentimos, error al generar la grafica';
   }
   function imagen()
   {
      $image = file_get_contents('arbol.png');
      $img64 = base64_encode($image);
      //return "<img src='data:image/png;base64,".$img64."' />";//debug
      return $img64;
   }
?>