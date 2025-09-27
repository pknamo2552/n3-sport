$(document).ready(function() {
  $('#province_id').change(function(){
    var province_id = $('#province_id').val();
    var action = 'get_district';
    if(province_id != '')
    {
        $.ajax({
            url:"get_data.php",
            method:"POST",
            data:{province_id:province_id, action:action},
            dataType:"JSON",
            success:function(data)
            {
                $('#district_id').html(data);
                $('#subdistrict_id').html('<option value="">เลือกตำบล</option>');
                $('#zipcode').val('');
            }
        });
    }
    else
    {
      $('#district_id').html('<option value="">เลือกอำเภอ</option>');
      $('#subdistrict_id').html('<option value="">เลือกตำบล</option>');
      $('#zipcode').val('');
    }
});
$('#district_id').change(function(){
  var district_id = $('#district_id').val();
  var action = 'get_subdistrict';
  if(district_id != '')
  {
      $.ajax({
          url:"get_data.php",
          method:"POST",
          data:{district_id:district_id, action:action},
          dataType:"JSON",
          success:function(data)
          {
              $('#subdistrict_id').html(data);
              $('#zipcode').val('');
          }
      });
  }
  else
  {
    $('#subdistrict_id').html('<option value="">เลือกตำบล</option>');
    $('#zipcode').val('');
  }
});
$('#subdistrict_id').change(function(){
var subdistrict_id = $('#subdistrict_id').val();
var action = 'get_zipcode';
if(subdistrict_id != '')
{
    $.ajax({
        url:"get_data.php",
        method:"POST",
        data:{subdistrict_id:subdistrict_id, action:action},
        dataType:"JSON",
        success:function(data)
        {
            console.log(data);
            $('#zipcode').val(data);
        }
    });
}
else
{
  $('#zipcode').val('');
}
});
});
