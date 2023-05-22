<?php

if (file_exists('contact.json')) {
  $data = file_get_contents('contact.json');
  $contacts = json_decode($data, true);
  // print_r($contacts);
}

if (isset($_POST['name'])) {
  $contact = json_decode(file_get_contents('contact.json', true));
  $contact[] = [
    "id" => $_POST['con_id'],
    "name" => $_POST['name'],
    "contact" => $_POST['contact']
  ];
  $json_string = json_encode($contact);
  file_put_contents('contact.json', $json_string);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DESHBOARD</title>


  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>

<body>
  <h1>Hi , </h1>

  <div class="container">
    <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add New </button>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Contact Number</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (!empty($contacts)) {
          foreach ($contacts as $key => $contact) {
            // print_r($contact['name']);
        ?>
            <tr>
              <th scope="row" class="con_no"><?php echo  ++$key ?></th>
              <td><?php echo $contact['name']; ?></td>
              <td><?php echo $contact['contact']; ?></td>
              <td></td>
            </tr>

        <?php }
        } ?>
      </tbody>
    </table>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add New Contact</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <!-- form -->
          <form id="save-form">
            <input type="text" name="con_id" id="con_id" hidden>
            <div class="form-group">
              <label for="name">Name</label>
              <input tnype="text" class="form-control" id="name" name="name" placeholder="Enter Name">
            </div>
            <div class="form-group">
              <label for="contact">Contact Number</label>
              <input type="text" class="form-control" id="contact" name="contact" placeholder="Contact Number">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary contact-save">Save</button>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    $(document).on('click', '.contact-save', function() {

      name = $('#name').val();
      con_no = $('#contact').val();
      id_no = $('.con_no').length;
      $('#con_id').val(++id_no);
      form = $('#save-form').serialize();
      console.log(form, id_no);
      $.ajax({
        url: 'index.php',
        method: 'POST',
        data: form,
        success: function(res) {
          var a = '<tr> <th scope="row" class=\'con_no\' > ' + (id_no) + ' </th> <td> ' + name + ' </td> <td>' + con_no + ' </td> <td></td> </tr>'
          $('body').find('tbody').append(a);
        }
      })
      $('.modal').modal('hide');
    })

    $('#save-form').validate({
      rules: {
        name: {
          required: true,
        },
        contact: {
          required: true,
          minlength: 10,
          maxlength: 10,
        }
      },
      messages: {
        name: {
          required: "Please enter a name",
        },
        contact: {
          required: "Please enter a Contact Number",
          minlength: "please Enter a 10 digit Number min",
          maxlength: "Please Enter 10 digit Number max",
        }
      }
    })
  </script>
</body>

</html>