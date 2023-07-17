
<?php
print("
<dialog id='favDialog' style='border:0; position: absolute; top: 20%; left: 50%; max-width: 500px; padding: 16px; border-radius: 8px; min-height: 200px; width: 100vw; transform: translateX( -50%)'>
  <form class='form-wrapper' id ='form' action='/vexepro/requests/add_c' method='POST'>
    <div>
    <label>Người gửi</label>
    <input  class='form-item' placeholder='Họ tên người gửi' name='name'/>
    </div>
    <div>
    <label>Số tài khoản</label>
    <input  class='form-item' placeholder='Số tài khoản' name='bank_number'/>
    </div>
    <div>
    <label>Ngân hàng gửi</label>
    <input  class='form-item' placeholder='Ngân hàng' name='bank_name'/>
    </div>
    <div>
    <label>Số tiền gửi</label>
    <input  class='form-item' placeholder='Số tiền gửi' name='amount'/>
    </div>
    <div>
    <label>Nội dung</label>
    <input  class='form-item' placeholder='Nội dung' name='content'/>
    </div>
    <button class='button primary-button' type='submit' id='confirmBtn'>Gửi</button>
    <button class='button' value='cancel' formmethod='dialog'>Hủy</button>
  </form>
</dialog>
");

print("<script type='text/javascript'>
const favDialog = document.getElementById('favDialog');
const confirmBtn = favDialog.querySelector('#confirmBtn');
const form = favDialog.querySelector('#form');

function showDialog(id){
    favDialog.showModal();
    const id_input = document.createElement('input');
    id_input.name = 'ticket_id';
    id_input.setAttribute('value', id);
    id_input.setAttribute('style', 'visibility: hidden;display: none');
    form.appendChild(id_input);
}

confirmBtn.addEventListener('click', (event) => {
    favDialog.close();
});
</script>"
);


?>