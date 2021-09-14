<?=$this->get_message()?>
<div class="overlay"></div>
<div id="reply_box" class="text-center">
    <h4>الرد على الرساله</h4>
    <form action="/admin/messages/reply" method="post">
        <?=$this->_token()?>
        <input type="hidden" name="email" value=""/>
        <input type="hidden" name="msg_id" value=""/>
        <div class="inpt-parent">
            <input type="text" name="subject" class="form-control" placeholder="عنوان الرساله" required="required"/>
        </div>
        <div class="inpt-parent">
            <textarea name="msg" class="form-control" placeholder="محتوى الرساله" required="required"></textarea>
        </div>
        <div>
            <button class="btn main-btn">إرسال</button>
        </div>
    </form>
</div>
<section class="admin-logged admin-dashboard text-center">
    <div id="all-users">
        <div class="container-fluid">
            <h4 class="h3">الرسائل الوارده</h4>
            <div class="actions">
                <input class="form-control" placeholder="ابحث عن المستخدمين (يمكنك كتابة قيمة أي عنصر من عناصر الجدول)" type="search" id="search-front">
            </div>
            <?php if(!empty($this->messages)): ?>
            <table id="users-table" class="table">
                <thead>
                    <tr>
                        <th class="main-color text-center">#id</th>
                        <th class="main-color text-center">الاسم</th>
                        <th class="main-color text-center">البريد الالكتروني</th>
                        <th class="main-color text-center">عنوان الرسالة</th>
                        <th class="main-color text-center">محتوى الرسالة</th>
                        <th class="main-color text-center">تاريخ الارسال</th>
                        <th class="main-color text-center">الإجراء</th>
                    </tr>
                </thead>
                <tbody id="myTable">
                <?php foreach($this->messages as $msg): ?>
                    <tr <?=$this->is_reply($msg)?>>
                        <td><?=$msg['id']?></td>
                        <td><?=$msg['full_name']?></td>
                        <td><?=$msg['email']?></td>
                        <td><?=$msg['subject']?></td>
                        <td><?=$msg['msg']?></td>
                        <td><?=$msg['send_at']?></td>
                        <td>
                            <button title="reply message" data-id="<?=$msg['id']?>" data-email="<?=$msg['email']?>" class="btn ban-btn reply_msg">الرد</button>
                            <a title="delete message" href="/admin/messages/delete/<?=$msg['id']?>" class="btn btn-danger need_confirm">مسح</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-center">
                <button id="load_more" class="btn main-btn">تحميل المزيد</button>
            </div>
            <?php else: ?>
            <div class="text-center">
                <p class="lead">لا يوجد رسائل تواصل بعد</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<script>
    window.onload = function(){
        $(".reply_msg").on("click",function(){
            var email = $(this).data("email"),
                id = $(this).data("id");
            $("input[name='email']").val(email);
            $("input[name='msg_id']").val(id);
            $(".overlay").fadeIn();
            $("#reply_box").fadeIn();
        });
        $(".overlay").on("click",function(){
            $(".overlay").fadeOut();
            $("#reply_box").fadeOut();
        });
        $("#load_more").on("click",function(){
            var data = {
                
            };
            ajaxRequest("/admin/messages/load_more","POST",data,"html",success_request,failed_request);
        });

        function success_request(data){
            data = JSON.parse(data)['data'];
            if(data.length <= 0){
                $("#load_more").parent().remove();
                return;
            };
            data.forEach(function(e){
                var html = "<tr "+is_reply(e)+">";
                    html += "<td>"+e.id+"</td>";
                    html += "<td>"+e.full_name+"</td>";
                    html += "<td>"+e.email+"</td>";
                    html += "<td>"+e.subject+"</td>";
                    html += "<td>"+e.msg+"</td>";
                    html += "<td>"+e.send_at+"</td>";
                    html += "<td>";
                    html += '<button title="reply message" data-id="'+e.id+'" class="btn ban-btn reply_msg">الرد</button>';
                    html += '<a title="delete message" href="/admin/messages/delete/'+e.id+'" class="btn btn-danger need_confirm">مسح</a>';
                    html += "</tr>";
                $("#myTable").append(html);
            });
        }
        function failed_request(data){
            console.log(data);
        }
        function is_reply(e){
            return e.is_reply == 1 ? "style='background:white'" : "style='background:#ececec'";
        }
    }
</script>