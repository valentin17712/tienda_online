<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://www.paypal.com/sdk/js?client-id=AUYbtkYuATflJq9T6GjuLmtxHwfkxHx6UNlT-GvJD5a7xwzXvRAFDayyMqc9szq6xx4YQ8InAPJ3TeA0&currency=MXN"></script>
  <title>Flash Electronics</title>
</head>

<body>
  
      
       <div id="paypal-button-container"></div>

       <script>

        paypal.Buttons({

          style:{
            color: 'blue',
            shape: 'pill',
            label: 'pay'


          }, 
          createOrder: function(data, actions){
            return actions.order.create({
              purchase_units:[{
                amount:{
                  value: 200
                }
              }]
            })
          },

          onApprove: function(data, actions){

            actions.order.capture().then(function(detalles){
             // console.log(detalles);
              window.location.href="completado.html";
            });

          },

          onCancel: function(data){
            alert("Pago cancelado");
            console.log(data);
          }

        }).render('#paypal-button-container');



       </script>





</body>
</html>