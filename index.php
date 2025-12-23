<?php
// Render Environment Variables bo'limidan ma'lumotlarni olish
$bot_token = getenv('BOT_TOKEN');
$admin_id = getenv('ADMIN_ID');
$channel_user = getenv('CHANNEL_USER');

// Agar Renderda hali kiritilmagan bo'lsa, kod buzilmasligi uchun tekshiruv (ixtiyoriy)
if (!$bot_token) {
    // Vaqtincha logga yozish yoki to'xtatish
    error_log("Diqqat: BOT_TOKEN topilmadi. Render sozlamalarini tekshiring!");
}

// O'zgaruvchilarni o'z o'rniga qo'yish
define('API_KEY', $bot_token);  

$admin = $admin_id;
$kanalim = $channel_user;

// ... kodning davomi


function bot($method,$datas=[]){
$url = "https://api.telegram.org/bot".API_KEY."/".$method;
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
$res = curl_exec($ch);
if(curl_error($ch)){
var_dump(curl_error($ch));
}else{
return json_decode($res);
}}
//Tarqatgan kod mehnatimni qadrlela @uzdev_php & @Qiziq_Coders
function hisob(){
$text = "🏆 TOP10 = Hisoblar\n\n";
$daten = [];
$rev = [];
$fayllar = glob("foydalanuvchi/hisob/*.*");
foreach($fayllar as $file){
if(mb_stripos($file,".txt")!==false){
$value = file_get_contents($file);
$id = str_replace(["foydalanuvchi/hisob/",".txt"],["",""],$file);
$daten[$value] = $id;
$rev[$id] = $value;
}
echo $file;
}
asort($rev);
$reversed = array_reverse($rev);
for($i=0;$i<10;$i+=1){
$order = $i+1;
$id = $daten["$reversed[$i]"];
$text.= "<b>{$order}</b>. <a href='tg://user?id={$id}'>{$id}</a> - "."<code>".$reversed[$i]."</code>"." <b>so'm</b>"."\n";
}
return $text;
}

function addstat($id){
    $check = file_get_contents("statistika/obunachi.txt");
    $rd = explode("\n",$check);
    if(!in_array($id,$rd)){
        file_put_contents("statistika/obunachi.txt","\n".$id,FILE_APPEND);
    }
}

function dostlar(){
$text2 = "🏆 TOP10 = Do'stlar\n\n";
$daten2 = [];
$rev2 = [];
$fayllar2 = glob("foydalanuvchi/referal/*.*");
foreach($fayllar2 as $file2){
if(mb_stripos($file2,".txt")!==false){
$value2 = file_get_contents($file2);
$id2 = str_replace(["foydalanuvchi/referal/",".txt"],["",""],$file2);
$daten2[$value2] = $id2;
$rev2[$id2] = $value2;
}
echo $file2;
}
asort($rev2);
$reversed2 = array_reverse($rev2);
for($i2=0;$i2<10;$i2+=1){
$order2 = $i2+1;
$id2 = $daten2["$reversed2[$i2]"];
$text2.= "<b>{$order2}</b>. <a href='tg://user?id={$id2}'>{$id2}</a> - "."<code>".$reversed2[$i2]."</code>"." <b>ta</b>"."\n";
}
return $text2;
}

function deleteFolder($path){
if(is_dir($path) === true){
$files = array_diff(scandir($path), array('.', '..'));
foreach ($files as $file)
deleteFolder(realpath($path) . '/' . $file);
return rmdir($path);
}else if (is_file($path) === true)
return unlink($path);
return false;
}

function joinchat($id){
global $mid;
$array = array("inline_keyboard");
$kanallar=file_get_contents("sozlamalar/kanal/ch.txt");
$ex = explode("\n",$kanallar);
for($i=0;$i<=count($ex) -1;$i++){
$first_line = $ex[$i];
$first_ex = explode("@",$first_line);
$url = $first_ex[1];
$ism=bot('getChat',['chat_id'=>"@".$url,])->result->title;
$ret = bot("getChatMember",[
"chat_id"=>"@$url",
"user_id"=>$id,
]);
$stat = $ret->result->status;
if((($stat=="creator" or $stat=="administrator" or $stat=="member"))){
$array['inline_keyboard']["$i"][0]['text'] = "✅ ". $ism;
$array['inline_keyboard']["$i"][0]['url'] = "https://t.me/$url";
}else{
$array['inline_keyboard']["$i"][0]['text'] = "❌ ". $ism;
$array['inline_keyboard']["$i"][0]['url'] = "https://t.me/$url";
$uns = true;
}}

if($uns == true){
bot("sendMessage",[
"chat_id"=>$id,
"text"=>"<b>⚠️ Botdan foydalanish uchun quyidagi kanalimizga azo bo'ling va /start  bosing!</b>",
"parse_mode"=>"html",
"reply_to_message_id"=>$mid,
"disable_web_page_preview"=>true,
"reply_markup"=>json_encode($array),
]);
return false;
}else{
return true;
}}

//Tarqatgan kod mehnatimni qadrlela @uzdev_php & @Qiziq_Coders
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$cid = $message->chat->id;
$tx = $message->text;
$mid = $message->message_id;
$name = $message->from->first_name;
$fid = $message->from->id;
$callback = $update->callback_query;
$data = $callback->data;
$callid = $callback->id;
$ccid = $callback->message->chat->id;
$cmid = $callback->message->message_id;
$from_id = $update->message->from->id;
$token = $message->text;
$text = $message->text;
$message_id = $callback->message->message_id;
$data = $update->callback_query->data;
$callcid=$update->callback_query->message->chat->id;
$doc = $update->message->document;
$doc_id = $doc->file_id;
$cqid = $update->callback_query->id;
$callfrid = $update->callback_query->from->id;
$botname = bot('getme',['FastKonsBot'])->result->username;
$callname = $update->callback_query->from->first_name;
$calluser = $update->callback_query->from->username;
#-----------------------------
mkdir("foydalanuvchi");
mkdir("foydalanuvchi/sarmoya/$fid");
mkdir("foydalanuvchi/bot/$fid");
mkdir("foydalanuvchi/sarhisob");
mkdir("foydalanuvchi/sarmoya");
mkdir("foydalanuvchi/referal");
mkdir("foydalanuvchi/hisob");
mkdir("sozlamalar/hamyon");
mkdir("sozlamalar/kanal");
mkdir("sozlamalar/tugma");
mkdir("sozlamalar/bot");
mkdir("sozlamalar/pul");
mkdir("statistika");
mkdir("sozlamalar");
mkdir("otkazma");
mkdir("botlar");
mkdir("step");
mkdir("baza");
mkdir("ban");
#-----------------------------

if(!file_exists("foydalanuvchi/hisob/$fid.1.txt")){
file_put_contents("foydalanuvchi/hisob/$fid.1.txt","0");
}
if(!file_exists("foydalanuvchi/hisob/$fid.1txt")){
file_put_contents("foydalanuvchi/hisob/$fid.1txt","0");
}
if(!file_exists("foydalanuvchi/hisob/$fid.txt")){
file_put_contents("foydalanuvchi/hisob/$fid.txt","0");
}
if(!file_exists("foydalanuvchi/sarhisob/$fid.kiritgan")){
file_put_contents("foydalanuvchi/sarhisob/$fid.kiritgan","0");
}
if(!file_exists("foydalanuvchi/sarhisob/$fid.chiqargan")){
file_put_contents("foydalanuvchi/sarhisob/$fid.chiqargan","0");
}
if(!file_exists("foydalanuvchi/referal/$fid.txt")){
file_put_contents("foydalanuvchi/referal/$fid.txt","0");
}
if(!file_exists("foydalanuvchi/sarmoya/$fid/sarson.txt")){  
file_put_contents("foydalanuvchi/sarmoya/$fid/sarson.txt","0");
}
if(!file_exists("sozlamalar/pul/referal.txt")){
file_put_contents("sozlamalar/pul/referal.txt","100");
}
if(!file_exists("sozlamalar/pul/valyuta.txt")){
file_put_contents("sozlamalar/pul/valyuta.txt","so'm");
}
if(!file_exists("sozlamalar/tugma/tugma1.txt")){
file_put_contents("sozlamalar/tugma/tugma1.txt","➕ Kod olish");
}
if(!file_exists("sozlamalar/tugma/tugma2.txt")){
file_put_contents("sozlamalar/tugma/tugma2.txt","🗄 Kabinet");
}
if(!file_exists("sozlamalar/tugma/tugma3.txt")){
file_put_contents("sozlamalar/tugma/tugma3.txt","💵 Pul ishlash");
}
if(!file_exists("sozlamalar/tugma/tugma4.txt")){
file_put_contents("sozlamalar/tugma/tugma4.txt","☎️ Murojaat");
}
if(!file_exists("sozlamalar/tugma/tugma5.txt")){
file_put_contents("sozlamalar/tugma/tugma5.txt","📮 Tekin Reklama");
}
if(!file_exists("sozlamalar/tugma/tugma6.txt")){
file_put_contents("sozlamalar/tugma/tugma6.txt","💎 Investitsiya");
}
if(!file_exists("sozlamalar/tugma/tugma7.txt")){
file_put_contents("sozlamalar/tugma/tugma7.txt","🔗 Taklifnoma");
}
if(!file_exists("sozlamalar/kanal/ch.txt")){
file_put_contents("sozlamalar/kanal/ch.txt","@qiziq_Coders");
}
if(!file_exists("otkazma/$fid.idraqam")){  
file_put_contents("otkazma/$fid.idraqam","");
}
if(!file_exists("otkazma/$fid.pulraqam")){  
file_put_contents("otkazma/$fid.pulraqam","");
}
if(!file_exists("statistika/hammabot.txt")){  
file_put_contents("statistika/hammabot.txt","0");
}
if(!file_exists("statistika/aktivbot.txt")){  
file_put_contents("statistika/aktivbot.txt","0");
}
if(file_get_contents("statistika/obunachi.txt")){
} else{
file_put_contents("statistika/obunachi.txt", "0");
}
if(!file_exists("baza/all.num")){  
file_put_contents("baza/all.num","0");
}

$kiritgan=file_get_contents("foydalanuvchi/hisob/$fid.1.txt");
$odam=file_get_contents("foydalanuvchi/referal/$fid.txt");
$odamcha = file_get_contents("foydalanuvchi/referal/$fid.db");
$asosiy=file_get_contents("foydalanuvchi/hisob/$fid.txt");
$sar=file_get_contents("foydalanuvchi/hisob/$fid.1txt");
$sarson = file_get_contents("foydalanuvchi/sarmoya/$fid/sarson.txt");
$pul = file_get_contents("sozlamalar/pul/valyuta.txt");
$taklifpul = file_get_contents("sozlamalar/pul/referal.txt");
$tugma1 = file_get_contents("sozlamalar/tugma/tugma1.txt");
$tugma2 = file_get_contents("sozlamalar/tugma/tugma2.txt");
$tugma3 = file_get_contents("sozlamalar/tugma/tugma3.txt");
$tugma4 = file_get_contents("sozlamalar/tugma/tugma4.txt");
$tugma5 = file_get_contents("sozlamalar/tugma/tugma5.txt");
$tugma6 = file_get_contents("sozlamalar/tugma/tugma6.txt");
$tugma7 = file_get_contents("sozlamalar/tugma/tugma7.txt");
$kanallar=file_get_contents("sozlamalar/kanal/ch.txt");
#-----------------------------------#
$kategoriya = file_get_contents("sozlamalar/bot/kategoriya.txt");
$royxat = file_get_contents("sozlamalar/bot/$kategoriya/royxat.txt");
$type = file_get_contents("sozlamalar/bot/$kategoriya/$royxat/turi.txt");
$narx = file_get_contents("sozlamalar/bot/$kategoriya/$royxat/narx.txt");
$tavsif = file_get_contents("sozlamalar/bot/$kategoriya/$royxat/tavsif.txt");
$botkodi = file_get_contents("sozlamalar/bot/$kategoriya/$royxat/url.txt");
#-----------------------------------#
$kategoriya2 = file_get_contents("sozlamalar/hamyon/kategoriya.txt");
$raqam = file_get_contents("sozlamalar/hamyon/$kategoriya2/raqam.txt");
#-----------------------------------#

//Tarqatgan kot mehnatimni qadrlela @uzdev_php & @Qiziq_Coders
//Tarqatgan kot mehnatimni qadrlela @uzdev_php & @Qiziq_Coders

$saved = file_get_contents("step/odam.txt");
$num = file_get_contents("baza/all.num");
$ban = file_get_contents("ban/$fid.txt");
$statistika = file_get_contents("statistika/obunachi.txt");
$aktivbot=file_get_contents("statistika/aktivbot.txt");
$hammabot=file_get_contents("statistika/hammabot.txt");
$soat=date("H:i",strtotime("2 hour"));
$referalsum = file_get_contents("foydalanuvchi/hisob/$fid.txt");
$referalid = file_get_contents("foydalanuvchi/referal/$fid.referal");
$referalcid = file_get_contents("foydalanuvchi/referal/$ccid.referal");
$userstep=file_get_contents("step/$fid.txt");
$userstep1=file_get_contents("step/$fid.txt1");

if(mb_stripos($text,"/start $cid")){
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"",
'parse_mode'=>'html',
]);
}else{
$idref = "foydalanuvchi/referal/$ex.db";
$idref2 = file_get_contents($idref);
$id = "$cid\n";
$handle = fopen($idref, 'a+');
fwrite($handle, $id);
fclose($handle);
if(mb_stripos($idref2,$cid) !== false ){
}else{
$pub=explode(" ",$text);
$ex=$pub[1];
$pulim = file_get_contents("foydalanuvchi/hisob/$ex.txt");
$a=$pulim+$taklifpul;
file_put_contents("foydalanuvchi/hisob/$ex.txt","$a");
$odam = file_get_contents("foydalanuvchi/referal/$ex.txt");
$b=$odam+1;
file_put_contents("foydalanuvchi/referal/$ex.txt","$b");
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"",
'parse_mode'=>'html',
'reply_markup'=>$main_menu,
]);
bot('SendMessage',[
'chat_id'=>$ex,
'text'=>"<b>📳 Sizda yangi <a href='tg://user?id=$cid'>taklif</a> mavjud!</b>

<i>Hisobingizga $taklifpul $pul qo'shildi!</i>",
'parse_mode'=>'html',
]);
}}

//Tarqatgan kot mehnatimni qadrlela @uzdev_php & @Qiziq_Coders
//Tarqatgan kot mehnatimni qadrlela @uzdev_php & @Qiziq_Coders

if($tx){
if($ban == "ban"){
exit();
}else{
}}

if($data){
$ban = file_get_contents("ban/$ccid.txt");
if($ban == "ban"){
exit();
}else{
}}

$main_menu = json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"$tugma1"]],
[['text'=>"$tugma2"],['text'=>"$tugma3"]],
[['text'=>"$tugma5"],['text'=>"$tugma4"]],
[['text'=>"📩 Reklama Xizmati"]],
]]);

$main_menuad = json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"$tugma1"]],
[['text'=>"$tugma2"],['text'=>"$tugma3"]],
[['text'=>"$tugma5"],['text'=>"$tugma4"]],
[['text'=>"🗄 Boshqaruv"]],
]]);

$admin1_menu = json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"📊 Statistika"]],
[['text'=>"📢 Kanallar"],['text'=>"➕ Kod qo'shish"]],
[['text'=>"🔎 Foydalanuvchini boshqarish"]],
[['text'=>"🎛 Tugmalar"],['text'=>"💳 Hamyonlar"]],
[['text'=>"📨 Xabarnoma"],['text'=>"◀️ Orqaga"]],
]]);

if($data == "boshqaruv" and $ccid == $admin){
bot('deleteMessage',[
'chat_id'=>$admin,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>🗄 Boshqaruv paneliga xush kelibsiz!</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
unlink("step/odam.txt");
}

if(isset($message)){
$get = file_get_contents("statistika/obunachi.txt");
if(mb_stripos($get,$fid)==false){
file_put_contents("statistika/obunachi.txt", "$get\n$fid");
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>👤 Yangi aʼzo
✉️ Lichka:</b> <a href='tg://user?id=$fid'>$name</a>",
'parse_mode'=>"html"
]);
}}

$orqaga1 = json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]]
]
]);
if($tx == "🗄 Boshqaruv" and $cid == $admin){
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>🗄 Boshqaruv paneliga xush kelibsiz!</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu
]);
unlink("step/$cid.txt");
unlink("miqdor.txt");
unlink("fbsh.txt");
}

$oddiy_xabar = file_get_contents("oddiy.txt");
if($data == "oddiy_xabar" and $ccid==$admin){
$lichka=file_get_contents("statistika/obunachi.txt");
$lich=substr_count($lichka,"\n");
bot('deleteMessage',[
'chat_id'=>$admin,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>$lich ta foydalanuvchiga yuboriladigan xabar matnini yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("oddiy.txt","oddiy");
}
if($oddiy_xabar=="oddiy" and $cid==$admin){
if($tx=="🗄 Boshqaruv"){
unlink("oddiy.txt");
}else{
$lichka=file_get_contents("statistika/obunachi.txt");
$lich=substr_count($lichka,"\n");
bot('sendmessage',[
'chat_id'=>$admin,
'text'=>"<b>$lich ta foydalanuvchiga xabar yuborish boshlandi!</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
$lich = file_get_contents("statistika/obunachi.txt");
$lichka = explode("\n",$lich);
foreach($lichka as $lichkalar){
$usr=bot("sendMessage",[
'chat_id'=>$lichkalar,
'text'=>$text,
'parse_mode'=>'HTML'
]);
unlink("oddiy.txt");
}}}
if($usr){
$lichka=file_get_contents("statistika/obunachi.txt");
$lich=substr_count($lichka,"\n");
bot("sendmessage",[
'chat_id'=>$admin,
'text'=>"<b>$lich ta foydalanuvchiga muvaffaqiyatli yuborildi</b>",
'parse_mode'=>'html',
'reply_markup'=>$admin1_menu,
]);
unlink("oddiy.txt");
}

$forward_xabar = file_get_contents("forward.txt");
if($data =="forward_xabar" and $ccid==$admin){
$lichka=file_get_contents("statistika/obunachi.txt");
$lich=substr_count($lichka,"\n");
bot('deleteMessage',[
'chat_id'=>$admin,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>$lich ta foydalanuvchiga yuboriladigan xabarni forward shaklida yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("forward.txt","forward");
}
if($forward_xabar=="forward" and $cid==$admin){
if($tx=="🗄 Boshqaruv"){
unlink("forward.txt");
}else{
$lichka=file_get_contents("statistika/obunachi.txt");
$lich=substr_count($lichka,"\n");
bot('sendmessage',[
'chat_id'=>$admin,
'text'=>"<b>$lich ta foydalanuvchiga xabar yuborish boshlandi!</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
$lich = file_get_contents("statistika/obunachi.txt");
$lichka = explode("\n",$lich);
foreach($lichka as $lichkalar){
$fors=bot("forwardMessage",[
'from_chat_id'=>$cid,
'chat_id'=>$lichkalar,
'message_id'=>$mid,
]);
unlink("forward.txt");
}}}
if($fors){
$lichka=file_get_contents("statistika/obunachi.txt");
$lich=substr_count($lichka,"\n");
bot("sendmessage",[
'chat_id'=>$admin,
'text'=>"<b>$lich ta foydalanuvchiga muvaffaqiyatli yuborildi</b>",
'parse_mode'=>'html',
'reply_markup'=>$admin1_menu,
]);
unlink("forward.txt");
}

if($tx=="📨 Xabarnoma" and $cid==$admin){
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>📨 Yuboriladigan xabar turini tanlang:</b>",
'parse_mode'=>"html",
'reply_markup'=> json_encode([
'inline_keyboard'=>[
[['text'=>"Oddiy xabar",'callback_data'=>"oddiy_xabar"]],
[['text'=>"Forward xabar",'callback_data'=>"forward_xabar"]],
]])
]);
}

if($tx == "➕ Kod qo'shish" and $cid == $admin){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"➕ <b>Kodlarni sozlash bo'limidasiz:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"📂 Kategoriyalar",'callback_data'=>"kategoriya"]],
[['text'=>"➕ Kodlarni sozlash",'callback_data'=>"BotSet"]],
]])
]);
}

if($data == "bbosh"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"➕ <b>kodladni sozlash bo'limidasiz:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"📂 Kategoriyalar",'callback_data'=>"kategoriya"]],
[['text'=>"➕ Kodlarni sozlash",'callback_data'=>"BotSet"]],
]])
]);
}

if($data == "kategoriya"){
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"📂 <b>Quyidagilardan birini tanlang:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"➕ Kategoriya qo'shish",'callback_data'=>"AdKat"]],
[['text'=>"📄 Kategoriyalar ro'yxati",'callback_data'=>"listKat"]],
[['text'=>"◀️ Orqaga",'callback_data'=>"bbosh"]]
]])
]);
}

if($data == "BotSet"){
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"➕ <b>Quyidagilardan birini tanlang:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"➕ Kod qo'shish",'callback_data'=>"AdBot"]],
[['text'=>"📄 Kodlar ro'yxati",'callback_data'=>"listBot"]],
[['text'=>"◀️ Orqaga",'callback_data'=>"bbosh"]]
]])
]);
}

//Tarqatgan kot mehnatimni qadrlela @uzdev_php & @Qiziq_Coders
//Tarqatgan kot mehnatimni qadrlela @uzdev_php & @Qiziq_Coders

if($data == "listKat"){
$more = explode("\n",$kategoriya);
$soni = substr_count($kategoriya,"\n");
$keys=[];
for ($for = 1; $for <= $soni; $for++) {
$title=str_replace("\n","",$more[$for]);
$keys[]=["text"=>"$title - sozlash","callback_data"=>"setKat-$title"];
$keysboard2 = array_chunk($keys, 1);
$keysboard2[] = [['text'=>"◀️ Orqaga",'callback_data'=>"bbosh"]];
$key = json_encode([
'inline_keyboard'=>$keysboard2,
]);
}
if($kategoriya != null){
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"<b>📋 Kategoriyalar ro'yxati:</b>",
'parse_mode'=>'html',
'reply_markup'=>$key,
]);
}else{
bot('answerCallbackQuery',[
'callback_query_id'=>$callid,
'text'=>"😔 Kategoriyalar mavjud emas!",
'show_alert'=>true,
]);
}}

if(mb_stripos($data, "setKat-")!==false){
$ex = explode("-",$data);
$kat = $ex[1];
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"📁 <b>Kategoriya nomi:</b> $kat",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🗑 O'chirish",'callback_data'=>"delKat-$kat"]],
[['text'=>"◀️ Orqaga",'callback_data'=>"listKat"]]
]])
]);
}

if(mb_stripos($data, "delKat-")!==false){
$ex = explode("-",$data);
$kat = $ex[1];
$k = str_replace("\n".$kat."","",$kategoriya);
file_put_contents("sozlamalar/bot/kategoriya.txt",$k);
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"<b>O'chirish yakunlandi!</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"◀️ Orqaga",'callback_data'=>"kategoriya"]]
]
])
]);
deleteFolder("sozlamalar/bot/$kat");
}

if($data == "listBot"){
$kategoriya = file_get_contents("sozlamalar/bot/kategoriya.txt");
$more = explode("\n",$kategoriya);
$soni = substr_count($kategoriya,"\n");
$keys=[];
for ($for = 1; $for <= $soni; $for++) {
$title=str_replace("\n","",$more[$for]);
$keys[]=["text"=>"$title ⏩","callback_data"=>"setBot-$title"];
$keysboard2 = array_chunk($keys, 1);
$keysboard2[] = [['text'=>"◀️ Orqaga",'callback_data'=>"bbosh"]];
$key = json_encode([
'inline_keyboard'=>$keysboard2,
]);
}
if($kategoriya != null){
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"<b>📋 Kategoriyalardan birini tanlang:</b>",
'parse_mode'=>'html',
'reply_markup'=>$key,
]);
}else{
bot('answerCallbackQuery',[
'callback_query_id'=>$callid,
'text'=>"😔 Kategoriyalar mavjud emas!",
'show_alert'=>true,
]);
}}

if(mb_stripos($data, "setBot-")!==false){
$ex = explode("-",$data);
$kat = $ex[1];
$royxat = file_get_contents("sozlamalar/bot/$kat/royxat.txt");
$kategoriya = file_get_contents("sozlamalar/bot/kategoriya.txt");
$more = explode("\n",$royxat);
$soni = substr_count($royxat,"\n");
$keys=[];
for ($for = 1; $for <= $soni; $for++) {
$title=str_replace("\n","",$more[$for]);
$keys[]=["text"=>"⚙ $title","callback_data"=>"bset-$title-$kat"];
$keysboard2 = array_chunk($keys, 2);
$keysboard2[] = [['text'=>"◀️ Orqaga",'callback_data'=>"bbosh"]];
$key = json_encode([
'inline_keyboard'=>$keysboard2,
]);
}
if($royxat != null){
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"📋 <b>Botlar ro'yxati:</b>",
'parse_mode'=>'html',
'reply_markup'=>$key,
]);
}else{
bot('answerCallbackQuery',[
'callback_query_id'=>$callid,
'text'=>"📂 Botlar mavjud emas!",
'show_alert'=>true,
]);
}}

if(mb_stripos($data, "bset-")!==false){
$ex = explode("-",$data);
$roy = $ex[1];
$kat = $ex[2];
$botkodi = file_get_contents("sozlamalar/bot/$kategoriya/$royxat/url.txt");
$narx = file_get_contents("sozlamalar/bot/$kat/$roy/narx.txt");
$tavsif = file_get_contents("sozlamalar/bot/$kat/$roy/tavsif.txt");
$type = file_get_contents("sozlamalar/bot/$kat/$roy/turi.txt");
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"<b>➕ $type</b>

<b>💬 Bot tili:</b> O'zbekcha
<b>💵 Narxi:</b> $narx $pul

📋 <b>Qo'shimcha ma'lumot:</b> <i>$tavsif</i>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🗑 O'chirish",'callback_data'=>"delBot-$kat-$roy-$type"]],
[['text'=>"◀️ Orqaga",'callback_data'=>"listBot"]]
]])
]);
}

if(mb_stripos($data, "delBot-")!==false){
$ex = explode("-",$data);
$kat = $ex[1];
$roy = $ex[2];
$type = $ex[3];
$royxat = file_get_contents("sozlamalar/bot/$kat/royxat.txt");
$k = str_replace("\n".$roy."","",$royxat);
file_put_contents("sozlamalar/bot/$kat/royxat.txt",$k);
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"<b>O'chirish yakunlandi!</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"◀️ Orqaga",'callback_data'=>"listBot"]]
]])
]);
deleteFolder("sozlamalar/bot/$kat/$roy");
unlink("sozlamalar/bot/$type.php");
}

if($data == "AdKat"){
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>📝 Yangi kategoriya nomini yuboring:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("step/$ccid.txt",'AdKat');
exit();
}

//Tarqatgan kot mehnatimni qadrlela @uzdev_php & @Qiziq_Coders
//Tarqatgan kot mehnatimni qadrlela @uzdev_php & @Qiziq_Coders

if($userstep == "AdKat"){
if($tx=="🗄 Boshqaruv"){
unlink("step/$cid.txt");
}else{
if($cid == $admin){
if(isset($text)){
$kategoriya = file_get_contents("sozlamalar/bot/kategoriya.txt");
file_put_contents("sozlamalar/bot/kategoriya.txt","$kategoriya\n$text");
mkdir("sozlamalar/bot/$text");
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"$text <b>nomli kategoriya qo'shildi</b>",
'parse_mode'=>'html',
'reply_markup'=>$admin1_menu,
]);
}
unlink("step/$cid.txt");
}}}

if($data == "AdBot"){
$kategoriya = file_get_contents("sozlamalar/bot/kategoriya.txt");
$more = explode("\n",$kategoriya);
$soni = substr_count($kategoriya,"\n");
$keys=[];
for ($for = 1; $for <= $soni; $for++) {
$title=str_replace("\n","",$more[$for]);
$keys[]=["text"=>"$title","callback_data"=>"addb-$title"];
$keysboard2 = array_chunk($keys, 1);
$keysboard2[] = [['text'=>"◀️ Orqaga",'callback_data'=>"bbosh"]];
$AdBot = json_encode([
'inline_keyboard'=>$keysboard2,
]);
}

if($kategoriya != null){
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"<b>📋 Qaysi kategoriyaga kod qo'shamiz?</b>",
'parse_mode'=>'html',
'reply_markup'=>$AdBot,
]);
}else{
bot('answerCallbackQuery',[
'callback_query_id'=>$callid,
'text'=>"😔 Kategoriyalar mavjud emas!",
'show_alert'=>true,
]);
}}

if(mb_stripos($data, "addb-")!==false){
$ex = explode("-",$data);
$kat = $ex[1];
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>✅ Kategoriya tanlandi</b>

📝 Kod turini yuboring: 
<i>Stikersiz yuboring!</i>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("step/$ccid.txt","turi-$kat");
exit();
}

if(mb_stripos($userstep, "turi-")!==false){
$ex = explode("-",$userstep);
$kat = $ex[1];
if($tx=="🗄 Boshqaruv"){
unlink("step/$cid.txt");
}else{
if(isset($text)){
$royxat = file_get_contents("sozlamalar/bot/$kat/royxat.txt");
file_put_contents("sozlamalar/bot/$kat/royxat.txt","$royxat\n$text");
mkdir("sozlamalar/bot/$kat/$text");
file_put_contents("sozlamalar/bot/$kat/$text/turi.txt",$text);
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"$text <b>nomi qabul qilindi.</b>

📝 Kod uchun narx yuboring:",
'parse_mode'=>'html',
]);
file_put_contents("step/$cid.txt","narxi-$kat-$text-$text");
}else{
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>⚠️ Faqat harflardan foydalaning!</b>",
'parse_mode'=>'html',
]);
}}}

if(mb_stripos($userstep, "narxi-")!==false){
$ex = explode("-",$userstep);
$kat = $ex[1];
$roy = $ex[2];
$type = $ex[3];
if($tx=="🗄 Boshqaruv"){
unlink("step/$cid.txt");
unlink("sozlamalar/bot/$kat/$roy");
$royxat = file_get_contents("sozlamalar/bot/$kat/royxat.txt");
$k = str_replace("\n".$roy."","",$royxat);
file_put_contents("sozlamalar/bot/$kat/royxat.txt",$k);
}else{
if(is_numeric($text)==true){
file_put_contents("sozlamalar/bot/$kat/$roy/narx.txt",$text);
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>$text </b>$pul narxi qabul qilindi

📝 Kod haqida qisqacha malumot yuboring:",
'parse_mode'=>'html',
]);
file_put_contents("step/$cid.txt","tavsif-$kat-$roy-$type");
}else{
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>⚠️ Faqat raqamlardan foydalaning!</b>",
'parse_mode'=>'html',
]);
}}}

if(mb_stripos($userstep, "tavsif-")!==false){
$ex = explode("-",$userstep);
$kat = $ex[1];
$roy = $ex[2];
$type = $ex[3];
if($tx=="🗄 Boshqaruv"){
unlink("step/$cid.txt");
unlink("sozlamalar/bot/$kat/$roy");
$royxat = file_get_contents("sozlamalar/bot/$kat/royxat.txt");
$k = str_replace("\n".$roy."","",$royxat);
file_put_contents("sozlamalar/bot/$kat/royxat.txt",$k);
}else{
if(isset($text)){
file_put_contents("sozlamalar/bot/$kat/$roy/tavsif.txt",$text);
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Qabul qilindi</b>

Endi bot kodi turgan post havolasini nusxalab menga jonating ",
'parse_mode'=>'html',
]);
file_put_contents("step/$cid.txt","script-$kat-$roy-$type");
}else{
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>⚠️ Faqat harflardan foydalaning!</b>",
'parse_mode'=>'html',
]);
}}}

if(mb_stripos($userstep, "script-")!==false){
$ex = explode("-",$userstep);
$kat = $ex[1];
$roy = $ex[2];
$type = $ex[3];
if($tx=="🗄 Boshqaruv"){
unlink("step/$cid.txt");
unlink("sozlamalar/bot/$kat/$roy");
$royxat = file_get_contents("sozlamalar/bot/$kat/url.txt");
$k = str_replace("\n".$roy."","",$royxat);
file_put_contents("sozlamalar/bot/$kat/url.txt",$k);
}else{
if(isset($text)){
file_put_contents("sozlamalar/bot/$kat/$roy/url.txt",$text);
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Qabul qilindi</b>",
'parse_mode'=>'html',
'reply_markup'=>$admin1_menu,
]);
file_put_contents("step/$cid.txt","caption-$kat-$roy-$type");
}else{
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>⚠️ Faqat harflardan foydalaning!</b>",
'parse_mode'=>'html',
]);
}}}

if(mb_stripos($userstep, "caption-")!==false){
$ex = explode("-",$userstep);
$kat = $ex[1];
$roy = $ex[2];
$type = $ex[3];
if($tx=="🗄 Boshqaruv"){
unlink("step/$cid.txt");
unlink("sozlamalar/bot/$kat/$roy");
$royxat = file_get_contents("sozlamalar/bot/$kat/caption.txt");
$k = str_replace("\n".$roy."","",$royxat);
file_put_contents("sozlamalar/bot/$kat/caption.txt",$k);
}else{
if(isset($text)){
file_put_contents("sozlamalar/bot/$kat/$roy/caption.txt",$text);
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Qabul qilindi
Endi foydalanuvchi kod olayotgabda bot nima deyidhi kerak
Masalan $type bot kodi</b>",
'parse_mode'=>'html',
'reply_markup'=>$admin1_menu,
]);
unlink("step/$cid.txt");
}else{
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>⚠️ Faqat harflardan foydalaning!</b>",
'parse_mode'=>'html',
]);
}}}

$taklif=file_get_contents("taklif.txt");
if($data=="taklif_narxi" and $ccid==$admin){
bot('sendMessage',[
'chat_id'=>$admin,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>📝 Yangi qiymatni yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("taklif.txt","taklif");
}
if($taklif == "taklif" and $cid==$admin){
if($tx=="🗄 Boshqaruv"){
unlink("taklif.txt");
}else{
file_put_contents("sozlamalar/pul/referal.txt","$tx");
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Muvaffaqiyatli o'zgartirildi!</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu
]);
unlink("taklif.txt");
}}

$valyuta=file_get_contents("valyuta.txt");
if($data=="valyuta_nomi" and $ccid == $admin){
bot('sendMessage',[
'chat_id'=>$admin,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>📝 Yangi qiymatni yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("valyuta.txt","valyuta");
}
if($valyuta == "valyuta" and $cid==$admin){
if($tx=="🗄 Boshqaruv"){
unlink("valyuta.txt");
}else{
file_put_contents("sozlamalar/pul/valyuta.txt","$tx");
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Muvaffaqiyatli o'zgartirildi!</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu
]);
unlink("valyuta.txt");
}}

$fbsh = file_get_contents("fbsh.txt");
if($tx=="🔎 Foydalanuvchini boshqarish" and $cid == $admin){
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Kerakli foydalanuvchining ID raqamini yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("fbsh.txt","idraqam");
}

if($fbsh=="idraqam" and $cid==$admin){
if($tx=="🗄 Boshqaruv"){
unlink("fbsh.txt");
}else{
if(file_exists("ban/$tx.txt")){
if(file_exists("foydalanuvchi/hisob/$tx.txt")){
file_put_contents("step/odam.txt",$tx);
$asos = file_get_contents("foydalanuvchi/hisob/$tx.txt");
$tpul = file_get_contents("foydalanuvchi/hisob/$tx.1txt");
$kirit=file_get_contents("foydalanuvchi/hisob/$tx.1.txt");
$odam = file_get_contents("foydalanuvchi/referal/$tx.txt");
bot("sendMessage",[
"chat_id"=>$admin,
"text"=>"<b>✅ Foydalanuvchi topildi:</b> <a href='tg://user?id=$tx'>$tx</a>

<b>Asosiy balans:</b> $asos $pul
<b>Sarmoya balans:</b> $tpul $pul
<b>Takliflari:</b> $odam ta

<b>Kiritgan pullari:</b> $kirit $pul",
'parse_mode'=>"html",
"reply_markup"=>json_encode([
'inline_keyboard'=>[
[['text'=>"🔕 Bandan olish",'callback_data'=>"unban"]],
[['text'=>"➕ Pul qo'shish",'callback_data'=>"val_qoshish"],['text'=>"➖ Pul ayirish",'callback_data'=>"val_ayirish"]],
[['text'=>"📊 Sarmoya qo'shish",'callback_data'=>"tolov_qoshish"],['text'=>"📊 Sarmoya ayirish",'callback_data'=>"tolov_ayirish"]],
]])
]); 
unlink("fbsh.txt");
}else{
bot('SendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Ushbu foydalanuvchi botdan foydalanmaydi!</b>

<i>Qayta yuboring:</i>",
'parse_mode'=>'html',
]);
}}else{
if(file_exists("foydalanuvchi/hisob/$tx.txt")){
file_put_contents("step/odam.txt",$tx);
$asos = file_get_contents("foydalanuvchi/hisob/$tx.txt");
$tpul = file_get_contents("foydalanuvchi/hisob/$tx.1txt");
$kirit=file_get_contents("foydalanuvchi/hisob/$tx.1.txt");
$odam = file_get_contents("foydalanuvchi/referal/$tx.txt");
bot("sendMessage",[
"chat_id"=>$admin,
"text"=>"<b>✅ Foydalanuvchi topildi:</b> <a href='tg://user?id=$tx'>$tx</a>

<b>Asosiy balans:</b> $asos $pul
<b>Sarmoya balans:</b> $tpul $pul
<b>Takliflari:</b> $odam ta

<b>Kiritgan pullari:</b> $kirit $pul",
'parse_mode'=>"html",
"reply_markup"=>json_encode([
'inline_keyboard'=>[
[['text'=>"🔔 Banlash",'callback_data'=>"ban"]],
[['text'=>"➕ Pul qo'shish",'callback_data'=>"val_qoshish"],['text'=>"➖ Pul ayirish",'callback_data'=>"val_ayirish"]],
[['text'=>"📊 Sarmoya qo'shish",'callback_data'=>"tolov_qoshish"],['text'=>"📊 Sarmoya ayirish",'callback_data'=>"tolov_ayirish"]],
]])
]);
unlink("fbsh.txt");
}else{
bot('SendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Ushbu foydalanuvchi botdan foydalanmaydi!</b>

<i>Qayta yuboring:</i>",
'parse_mode'=>'html',
]);
}}}}

if($data=="ban"){
file_put_contents("ban/$saved.txt","ban");
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<a href='tg://user?id=$saved'>$saved</a> <b>banlandi</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
bot('sendMessage',[
'chat_id'=>$saved,
'text'=>"<b>Admin tomonidan bloklandingiz!</b>",
'parse_mode'=>"html",
]);
unlink("step/odam.txt");
}

if($data=="unban"){
unlink("ban/$saved.txt");
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<a href='tg://user?id=$saved'>$saved</a> <b>banlandan olindi</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
bot('sendMessage',[
'chat_id'=>$saved,
'text'=>"<b>Admin tomonidan blokdan olindingiz!</b>",
'parse_mode'=>"html",
]);
unlink("step/odam.txt");
}

$valqosh = file_get_contents("valqosh.txt");
if($data == "val_qoshish" and $ccid==$admin){
file_put_contents("valqosh.txt","valqosh");
bot('deleteMessage',[
'chat_id'=>$admin,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$admin,
'parse_mode'=>"html",
'text'=>"<a href='tg://user?id=$saved'>$saved</a> <b>ning hisobiga qancha pul qo'shmoqchisiz?</b>",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
}

if($valqosh == "valqosh" and $cid==$admin){
if($tx=="🗄 Boshqaruv"){
unlink("valqosh.txt");
unlink("step/odam.txt");
}else{
bot('sendMessage',[
'chat_id'=>$saved,
'text'=>"<b>Adminlar tomonidan hisobingiz $tx $pul to'ldirildi</b>",
'parse_mode'=>"html",
]);
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Foydalanuvchi hisobiga $tx $pul qo'shildi</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
$currency=file_get_contents("foydalanuvchi/hisob/$saved.1.txt");
$get = file_get_contents("foydalanuvchi/hisob/$saved.txt");
$get += $tx;
$currency += $tx;
file_put_contents("foydalanuvchi/hisob/$saved.1.txt",$currency);
file_put_contents("foydalanuvchi/hisob/$saved.txt", $get);
unlink("valqosh.txt");
unlink("step/odam.txt");
}}

$valayir = file_get_contents("valayir.txt");
if($data == "val_ayirish" and $ccid==$admin){
file_put_contents("valayir.txt","valayir");
bot('deleteMessage',[
'chat_id'=>$admin,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$admin,
'parse_mode'=>"html",
'text'=>"<a href='tg://user?id=$saved'>$saved</a> <b>ning hisobidan qancha pul ayirmoqchisiz?</b>",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
}

if($valayir == "valayir" and $cid==$admin){
if($tx=="🗄 Boshqaruv"){
unlink("valayir.txt");
unlink("step/odam.txt");
}else{
bot('sendMessage',[
'chat_id'=>$saved,
'text'=>"<b>Adminlar tomonidan hisobingizdan $tx $pul olib tashlandi</b>",
'parse_mode'=>"html",
]);
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Foydalanuvchi hisobidan $tx $pul olib tashlandi</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
$currency=file_get_contents("foydalanuvchi/hisob/$saved.1.txt");
$get = file_get_contents("foydalanuvchi/hisob/$saved.txt");
$get -= $tx;
$currency -= $tx;
file_put_contents("foydalanuvchi/hisob/$saved.1.txt",$currency);
file_put_contents("foydalanuvchi/hisob/$saved.txt", $get);
unlink("valayir.txt");
unlink("step/odam.txt");
}}

$tolqosh = file_get_contents("tvalqosh.txt");
if($data=="tolov_qoshish" and $ccid==$admin){
file_put_contents("tvalqosh.txt","tvalqosh");
bot('deleteMessage',[
'chat_id'=>$admin,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$admin,
'parse_mode'=>"html",
'text'=>"<a href='tg://user?id=$saved'>$saved</a> <b>ning sarmoya hisobiga qancha pul qo'shmoqchisiz?</b>",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
}

if($tolqosh == "tvalqosh" and $cid==$admin){
if($tx=="🗄 Boshqaruv"){
unlink("tvalqosh.txt");
unlink("step/odam.txt");
}else{
bot('sendMessage',[
'chat_id'=>$saved,
'text'=>"<b>Adminlar tomonidan sarmoya hisobingiz $tx $pul to'ldirildi</b>",
'parse_mode'=>"html",
]);
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Foydalanuvchi sarmoya hisobiga $tx $pul qo'shildi!</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
$currency=file_get_contents("foydalanuvchi/hisob/$saved.1.txt");
$currency += $tx;
file_put_contents("foydalanuvchi/hisob/$saved.1.txt",$currency);
$buyurtmab=file_get_contents("foydalanuvchi/hisob/$saved.1txt");
$buyurtmab+= $tx;
file_put_contents("foydalanuvchi/hisob/$saved.1txt", $buyurtmab);
unlink("tvalqosh.txt");
unlink("step/odam.txt");
}}

$tolayir = file_get_contents("tvalayir.txt");
if($data=="tolov_ayirish" and $ccid==$admin){
file_put_contents("tvalayir.txt","tvalayir");
bot('deleteMessage',[
'chat_id'=>$admin,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$admin,
'parse_mode'=>"html",
'text'=>"<a href='tg://user?id=$saved'>$saved</a> <b>ning sarmoya hisobidan qancha pul ayirmoqchisiz?</b>",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
}

if($tolayir == "tvalayir" and $cid==$admin){
if($tx=="🗄 Boshqaruv"){
unlink("tvalayir.txt");
unlink("step/odam.txt");
}else{
bot('sendMessage',[
'chat_id'=>$saved,
'text'=>"<b>Adminlar tomonidan sarmoya hisobingizdan $tx $pul olib tashlandi</b>",
'parse_mode'=>"html",
]);
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Foydalanuvchi sarmoya hisobidan $tx $pul olib tashlandi!</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
$currency=file_get_contents("foydalanuvchi/hisob/$saved.1.txt");
$currency -= $tx;
file_put_contents("foydalanuvchi/hisob/$saved.1.txt",$currency);
$buyurtmab=file_get_contents("foydalanuvchi/hisob/$saved.1txt");
$buyurtmab-= $tx;
file_put_contents("foydalanuvchi/hisob/$saved.1txt", $buyurtmab);
unlink("tvalayir.txt");
unlink("step/odam.txt");
}}

if($tx=="💳 Hamyonlar" and $cid==$admin){
$kategoriya = file_get_contents("sozlamalar/hamyon/kategoriya.txt");
$more = explode("\n",$kategoriya);
$soni = substr_count($kategoriya,"\n");
$keys=[];
for ($for = 1; $for <= $soni; $for++) {
$title=str_replace("\n","",$more[$for]);
$keys[]=["text"=>"$title- ni o'chirish","callback_data"=>"delete-$title"];
$keysboard2 = array_chunk($keys, 1);
$keysboard2[] = [['text'=>"➕ Yangi to'lov tizimi qo'shish",'callback_data'=>"yangi_tolov"]];
$keysboard2[] = [['text'=>"🔗 Taklif narxi",'callback_data'=>"taklif_narxi"],['text'=>"💶 Valyuta nomi",'callback_data'=>"valyuta_nomi"]];
$key = json_encode([
'inline_keyboard'=>$keysboard2,
]);
}
if($kategoriya != null){
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Quyidagilardan birini tanlang:</b>",
'parse_mode'=>"html",
'reply_markup'=>$key,
]);
}else{
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Quyidagilardan birini tanlang:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"➕ Yangi to'lov tizimi qo'shish",'callback_data'=>"yangi_tolov"]],
[['text'=>"🔗 Taklif narxi",'callback_data'=>"taklif_narxi"],['text'=>"💶 Valyuta nomi",'callback_data'=>"valyuta_nomi"]],
]])
]);
}}

if(mb_stripos($data, "delete-")!==false){
$ex = explode("-",$data);
$kat = $ex[1];
$royxat = file_get_contents("sozlamalar/hamyon/kategoriya.txt");
$k = str_replace("\n".$kat."","",$royxat);
file_put_contents("sozlamalar/hamyon/kategoriya.txt",$k);
deleteFolder("sozlamalar/hamyon/$kat");
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('SendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>To'lov tizimi o'chirildi!</b>",
'parse_mode'=>'html',
]);
}

if($data== "yangi_tolov"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('SendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>Yangi to'lov tizimi nomini yuboring:

Masalan:</b> Click",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("step/$ccid.txt","tolov");
}

if($userstep=="tolov"){
if($tx=="🗄 Boshqaruv"){
unlink("step/$cid.txt");
}else{
if(isset($text)){
$kategoriya2 = file_get_contents("sozlamalar/hamyon/kategoriya.txt");
file_put_contents("sozlamalar/hamyon/kategoriya.txt","$kategoriya2\n$text");
mkdir("sozlamalar/hamyon/$text");
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Ushbu to'lov tizimidagi hamyoningiz raqamini yuboring:</b>",
'parse_mode'=>'html',
]);
file_put_contents("step/$cid.txt","raqam-$text");
}else{
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Yangi to'lov tizimi nomini yuboring:

Masalan:</b> Click",
'parse_mode'=>'html',
]);
}}}

if(mb_stripos($userstep, "raqam-")!==false){
$ex = explode("-",$userstep);
$kat = $ex[1];
if($tx=="🗄 Boshqaruv"){
unlink("step/$cid.txt");
unlink("sozlamalar/hamyon/$kat");
}else{
if(is_numeric($text)){
file_put_contents("sozlamalar/hamyon/$kat/raqam.txt",$text);
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Yangi to'lov tizimi qo'shildi!</b>",
'parse_mode'=>'html',
'reply_markup'=>$admin1_menu,
]);
unlink("step/$cid.txt");
}else{
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Ushbu to'lov tizimidagi hamyoningiz raqamini yuboring:</b>",
'parse_mode'=>'html',
]);
}}}

if($tx=="🎛 Tugmalar" and $cid==$admin){
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>🎛 Tugma sozlash bo'limidasiz tanlang:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🖥 Asosiy menyudagi tugmalar",'callback_data'=>"asosiy_tugma"]],
[['text'=>"💵 Pul ishlash bo'limi tugmalari",'callback_data'=>"pulishlash_tugma"]],
[['text'=>"⚠️ O'z holiga qaytarish",'callback_data'=>"reset_tugma"]],
]])
]);
}

if($data=="tugma_sozlash" and $ccid==$admin){
bot('deleteMessage',[
'chat_id'=>$admin,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>🎛 Tugma sozlash bo'limidasiz tanlang:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🖥 Asosiy menyudagi tugmalar",'callback_data'=>"asosiy_tugma"]],
[['text'=>"💵 Pul ishlash bo'limi tugmalari",'callback_data'=>"pulishlash_tugma"]],
[['text'=>"⚠️ O'z holiga qaytarish",'callback_data'=>"reset_tugma"]],
]])
]);
}

if($data=="asosiy_tugma" and $ccid==$admin){
bot('editMessageText',[
'chat_id'=>$admin,
'message_id'=>$cmid,
'text'=>"<b>Quyidagilardan birini tanlang:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"$tugma1",'callback_data'=>"tg1"]],
[['text'=>"$tugma2",'callback_data'=>"tg2"],['text'=>"$tugma3",'callback_data'=>"tg3"]],
[['text'=>"$tugma5",'callback_data'=>"tg5"],['text'=>"$tugma4",'callback_data'=>"tg4"]],
[['text'=>"◀️ Orqaga",'callback_data'=>"tugma_sozlash"]],
]])
]);
}

$tugma=file_get_contents("tugma.txt");
if($data=="tg1" and $ccid == $admin){
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Tugma uchun yangi nom yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("tugma.txt","tg1");
}
if($tugma == "tg1" and $cid==$admin){
if($tx=="🗄 Boshqaruv"){
unlink("tugma.txt");
}else{
file_put_contents("sozlamalar/tugma/tugma1.txt","$tx");
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Qabul qilindi!</b>

<i>Tugma nomi</i> <b>$tx</b> <i>ga o'zgartirildi</i>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
unlink("tugma.txt");
}}

$tugma=file_get_contents("tugma.txt");
if($data=="tg2" and $ccid == $admin){
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Tugma uchun yangi nom yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("tugma.txt","tg2");
}
if($tugma == "tg2" and $cid==$admin){
if($tx=="🗄 Boshqaruv"){
unlink("tugma.txt");
}else{
file_put_contents("sozlamalar/tugma/tugma2.txt","$tx");
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Qabul qilindi!</b>

<i>Tugma nomi</i> <b>$tx</b> <i>ga o'zgartirildi</i>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
unlink("tugma.txt");
}}

$tugma=file_get_contents("tugma.txt");
if($data=="tg3" and $ccid == $admin){
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Tugma uchun yangi nom yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("tugma.txt","tg3");
}
if($tugma == "tg3" and $cid==$admin){
if($tx=="🗄 Boshqaruv"){
unlink("tugma.txt");
}else{
file_put_contents("sozlamalar/tugma/tugma3.txt","$tx");
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Qabul qilindi!</b>

<i>Tugma nomi</i> <b>$tx</b> <i>ga o'zgartirildi</i>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
unlink("tugma.txt");
}}

$tugma=file_get_contents("tugma.txt");
if($data=="tg4" and $ccid == $admin){
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Tugma uchun yangi nom yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("tugma.txt","tg4");
}
if($tugma == "tg4" and $cid==$admin){
if($tx=="🗄 Boshqaruv"){
unlink("tugma.txt");
}else{
file_put_contents("sozlamalar/tugma/tugma4.txt","$tx");
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Qabul qilindi!</b>

<i>Tugma nomi</i> <b>$tx</b> <i>ga o'zgartirildi</i>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
unlink("tugma.txt");
}}

$tugma=file_get_contents("tugma.txt");
if($data=="tg5" and $ccid == $admin){
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Tugma uchun yangi nom yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("tugma.txt","tg5");
}
if($tugma == "tg5" and $cid==$admin){
if($tx=="🗄 Boshqaruv"){
unlink("tugma.txt");
}else{
file_put_contents("sozlamalar/tugma/tugma5.txt","$tx");
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Qabul qilindi!</b>

<i>Tugma nomi</i> <b>$tx</b> <i>ga o'zgartirildi</i>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
unlink("tugma.txt");
}}

if($data=="pulishlash_tugma" and $ccid==$admin){
bot('editMessageText',[
'chat_id'=>$admin,
'message_id'=>$cmid,
'text'=>"<b>Quyidagilardan birini tanlang:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"$tugma7",'callback_data'=>"pultg2"]],
[['text'=>"◀️ Orqaga",'callback_data'=>"tugma_sozlash"]],
]])
]);
}

$tugma=file_get_contents("tugma.txt");
if($data=="pultg1" and $ccid == $admin){
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Tugma uchun yangi nom yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("tugma.txt","pultg1");
}
if($tugma == "pultg1" and $cid==$admin){
if($tx=="🗄 Boshqaruv"){
unlink("tugma.txt");
}else{
file_put_contents("sozlamalar/tugma/tugma6.txt","$tx");
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Qabul qilindi!</b>

<i>Tugma nomi</i> <b>$tx</b> <i>ga o'zgartirildi</i>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
unlink("tugma.txt");
}}

$tugma=file_get_contents("tugma.txt");
if($data=="pultg2" and $ccid == $admin){
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Tugma uchun yangi nom yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("tugma.txt","pultg2");
}
if($tugma == "pultg2" and $cid==$admin){
if($tx=="🗄 Boshqaruv"){
unlink("tugma.txt");
}else{
file_put_contents("sozlamalar/tugma/tugma7.txt","$tx");
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Qabul qilindi!</b>

<i>Tugma nomi</i> <b>$tx</b> <i>ga o'zgartirildi</i>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
unlink("tugma.txt");
}}

//Tarqatgan kot mehnatimni qadrlela @uzdev_php & @Qiziq_Coders
//Tarqatgan kot mehnatimni qadrlela @uzdev_php & @Qiziq_Coders

if($data=="reset_tugma" and $ccid==$admin){
bot('editMessageText',[
'chat_id'=>$admin,
'message_id'=>$cmid,
'text'=>"<b>Tugma nomlari o'chirilmoqda...</b>",
'parse_mode'=>"html",
]);
sleep(2);
bot('deleteMessage',[
'chat_id'=>$admin,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Tugma nomlari o'chirilib, o'z holiga qaytarildi!</b>",
'parse_mode'=>"html",
]);
unlink("sozlamalar/tugma/tugma1.txt");
unlink("sozlamalar/tugma/tugma2.txt");
unlink("sozlamalar/tugma/tugma3.txt");
unlink("sozlamalar/tugma/tugma4.txt");
unlink("sozlamalar/tugma/tugma5.txt");
unlink("sozlamalar/tugma/tugma6.txt");
unlink("sozlamalar/tugma/tugma7.txt");
}

$admin6_menu = json_encode([
'inline_keyboard'=>[
[['text'=>"🔐 Majburiy obuna",'callback_data'=>"majburiy_obuna"]],
]]);

if($data=="kanalsoz" and $ccid==$admin){
bot('deleteMessage',[
'chat_id'=>$admin,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Quyidagilardan birini tanlang:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🔐 Majburiy obuna",'callback_data'=>"majburiy_obuna"]],
]])
]);
unlink("step/$ccid.txt");
}

if($tx == "📊 Statistika" and $cid == $admin){
$lichka=file_get_contents("statistika/obunachi.txt");
$lich=substr_count($lichka,"\n");
$load = sys_getloadavg();
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>💡 O'rtacha yuklanish:</b> <code>$load[0]</code>

👥 <b>Foydalanuvchilar: $lich ta</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🔁 Yangilash",'callback_data'=>"stats"]],
[['text'=>"📊 Hisoblar",'callback_data'=>"hisob"],['text'=>"📊 Do'stlar",'callback_data'=>"dostlar"]],
]])
]);
}

if($data=="hisob" and $ccid == $admin){
bot('deleteMessage',[
'chat_id'=>$admin,
'message_id'=>$cmid,
]);
$hisoblar = hisob();
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"$hisoblar",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"◀️ Orqaga",'callback_data'=>"stats"]],
]])
]);
}

if($data=="dostlar" and $ccid == $admin){
bot('deleteMessage',[
'chat_id'=>$admin,
'message_id'=>$cmid,
]);
$dostlar = dostlar();
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"$dostlar",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"◀️ Orqaga",'callback_data'=>"stats"]],
]])
]);
}

if($data=="stats" and $ccid == $admin){
$lichka=file_get_contents("statistika/obunachi.txt");
$lich=substr_count($lichka,"\n");
$load = sys_getloadavg();
bot('deleteMessage',[
'chat_id'=>$admin,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>💡 O'rtacha yuklanish:</b> <code>$load[0]</code>

👥 <b>Foydalanuvchilar: $lich ta</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🔁 Yangilash",'callback_data'=>"stats"]],
[['text'=>"📊 Hisoblar",'callback_data'=>"hisob"],['text'=>"📊 Do'stlar",'callback_data'=>"dostlar"]],
]])
]);
}

if($tx=="📢 Kanallar" and $cid==$admin){
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Quyidagilardan birini tanlang:</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin6_menu
]);
}

if($data=="majburiy_obuna" and $ccid==$admin){
bot('editMessageText',[
'chat_id'=>$admin,
'message_id'=>$cmid,
'text'=>"<b>Majburiy obunalarni sozlash bo'limidasiz:</b>

<i>Avval <b>asosiy kanal</b>ni ulab keyin kanal qo'shing!</i>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"📋 Ro'yxatni ko'rish",'callback_data'=>"majburiy_obuna3"]],
[['text'=>"📢 Asosiy kanal",'callback_data'=>"majburiy_obuna4"],['text'=>"➕ Kanal qo'shish",'callback_data'=>"majburiy_obuna1"]],
[['text'=>"🗑 O'chirish",'callback_data'=>"majburiy_obuna2"],['text'=>"◀️ Orqaga",'callback_data'=>"kanalsoz"]],

]])
]);
unlink("step/$cid.txt");
}

$majburiy = file_get_contents("maj.txt");
if($data=="majburiy_obuna1" and $ccid == $admin){
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>📢 Kerakli kanalni manzilini yuboring:</b>

Namuna: <code>@Qiziq_Coders</code>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("maj.txt","majburiy1");
}
if($majburiy == "majburiy1" and $cid==$admin){
if($tx=="🗄 Boshqaruv"){
unlink("maj.txt");
}else{
if(isset($message)){
$kanal=file_get_contents("sozlamalar/kanal/ch.txt");
if(mb_stripos($kanal,$tx)==false){
file_put_contents("sozlamalar/kanal/ch.txt", "$kanal\n$tx");
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>$tx qabul qilindi!</b>

       @Qiziq_Coders kanaliga obuna bol

⚠️ @$botname ni kanalingizga admin qiling!",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
}}
unlink("maj.txt");
}}

$majburiy = file_get_contents("maj.txt");
if($data=="majburiy_obuna4" and $ccid == $admin){
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>📢 Kerakli kanalni manzilini yuboring:</b>

Namuna: <code>@Qiziq_Coders</code>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("maj.txt","majburiy4");
}
if($majburiy == "majburiy4" and $cid==$admin){
if($tx=="🗄 Boshqaruv"){
unlink("maj.txt");
}else{
deleteFolder("sozlamalar/kanal/ch.txt");
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>$tx qabul qilindi!</b>

⚠️ @$botname ni kanalingizga admin qiling!",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
file_put_contents("sozlamalar/kanal/ch.txt","$text");
unlink("maj.txt");
}}


$majburiyoc = file_get_contents("majoch.txt");
if($data=="majburiy_obuna2" and $ccid == $admin){
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>🗑 O'chiriladigan kanal manzilini yuboring:</b>

Namuna: <code>@Qiziq_Coders</code>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("majoch.txt","majoch");
}
if($majburiyoc=="majoch" and $cid==$admin){
if($tx=="🗄 Boshqaruv"){
unlink("majoch.txt");
}else{
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>🗑 $tx ni o'chirish yakunlandi</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
$kanal = file_get_contents("sozlamalar/kanal/ch.txt");
if(mb_stripos($kanal,$tx)!==false){
$ochir = str_replace("\n".$tx."","",$kanal);
file_put_contents("sozlamalar/kanal/ch.txt",$ochir);
unlink("majoch.txt");
}}}

if($data=="majburiy_obuna3" and $ccid==$admin){
if($kanallar==null){
bot('editMessageText',[
'chat_id'=>$admin,
'message_id'=>$cmid,
'text'=>"<b>Kanallar ulanmagan!</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"◀️ Orqaga",'callback_data'=>"majburiy_obuna"]],
]])
]);
}else{
$opshi=substr_count($kanallar,"\n");
bot('editMessageText',[
'chat_id'=>$admin,
'message_id'=>$cmid,
'text'=>"<b>Ulangan kanallar ro'yxati ⤵️</b>
➖➖➖➖➖➖➖➖
Qiziq_Coders

<b>Asosiy kanal:</b> <i>$kanallar</i>
",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"◀️ Orqaga",'callback_data'=>"majburiy_obuna"]],
]])
]);
}}

if($tx == "/panel"){
if($cid==$admin){
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>🗄 Boshqaruv paneliga xush kelibsiz!</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu
]);
}else{
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>🖥 Asosiy menyudasiz</b>",
'parse_mode'=>"html",
]);
}}

if($text == "/start"){
if($cid!= $admin){
bot('sendmessage',[
'chat_id'=>$cid,
'text'=>"<b>🖥 Asosiy menyudasiz</b>",
'parse_mode'=>'html',
'reply_markup'=>$main_menu,
]);
}else{
bot('SendMessage',[
'chat_id'=>$admin,
'text'=>"<b>🖥 Asosiy menyudasiz</b>",
'parse_mode'=>'html',
'reply_markup'=>$main_menuad,
]);
}}

if($tx=="$tugma1" and joinchat($fid)=="true"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>➕ Kod olish bo'limiga xush kelibsiz!</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"➕ Yangi kod olish"]],
[['text'=>"◀️ Orqaga"]],
]])
]);
}


if($text == "$tugma5" and joinchat($fid)=="true"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>$tugma5-ga xush kelibsiz</b>

<i>O'z mahsulotingizni soting yoki sotib oling!</i>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"📊 Statistika","callback_data"=>"botstat"]],
[['text'=>"📋 Elon joylash",'callback_data'=>"sotish"],['text'=>"📇 Elon kuzatish",'callback_data'=>"sotib_olish"]],
]])
]);
}

if($data=="men" and joinchat($ccid)=="true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>$tugma5-ga xush kelibsiz</b>

<i>O'z mahsulotingizni soting yoki sotib oling!</i>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"📊 Statistika","callback_data"=>"botstat"]],
[['text'=>"📋 Elon joylash",'callback_data'=>"sotish"],['text'=>"📇 Elon kuzatish",'callback_data'=>"sotib_olish"]],
]])
]);
}

if($data == "botstat" and joinchat($ccid)=="true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>🧾 Sotuvdagi mahsulotlar soni:</b> $num ta",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🗑 Bazani tozalash","callback_data"=>"tbaza=$admin"]],
[['text'=>"◀️ Orqaga","callback_data"=>"men"]],
]])
]);
}

if(stripos($data,"tbaza=")!==false && stripos($statistika,"$callfrid")!==false){
$ex = explode("=",$data);
$odam = $ex[1];
if(stripos($admin,"$callfrid")!== false){
bot("deletemessage",[
'chat_id'=>$admin,
'message_id'=>$cmid,
]);
bot('sendMessage',[
"chat_id"=>$odam,
"text"=>"🗑 <b>Baza tozalandi</b>",
"parse_mode"=>'html',
]);
deleteFolder("baza/");
}else{
bot('answercallbackquery',[
'callback_query_id'=>$cqid,
'text'=>"⚠️ Faqat admin tozalashi mumkin!",
'show_alert'=>true,
]);
}}

if($data == "sotish" and joinchat($ccid)=="true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>📝 Mahsulotingiz haqida malumot yozing:

Namuna:</b> <code>Bot turi: Nakrutka bot
Azosi: 500 ta
Useri: @Newauksion
Narxi: 50.000 so'm
Obmen: Yo'q</code>
Namuna:</b> <code>Turi: Telegram kanal
Azosi: 500 ta
Useri: @Qiziq_Coders
Narxi: 50.000 so'm
Ma'lumot: Global top
Obmen: Yo'q</code>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"◀️ Orqaga"]],
]])
]);
file_put_contents("step/$ccid.txt","bot_sotish");
}

if($userstep == "bot_sotish"){
if($cid==$admin){
if($tx=="◀️ Orqaga"){
unlink("step/$admin.txt");
}else{
$num=file_get_contents("baza/all.num");
$ok = $num + 1;
file_put_contents("baza/all.num","$ok");
file_put_contents("baza/$admin.num","$ok");
file_put_contents("baza/$ok.botext", "$tx");
file_put_contents("baza/$ok.admin",$admin);
unlink("step/$admin.txt");
bot("SendMessage",[
'chat_id'=>$admin,
'text'=>"<b>🧾 Mahsulotingiz sotuvga qo'shildi!</b>",
'parse_mode'=>'html',
'reply_markup'=>$main_menuad,
]);
unlink("step/$admin.txt");
}}else{
if($tx=="◀️ Orqaga"){
unlink("step/$cid.txt");
}else{
$num=file_get_contents("baza/all.num");
$ok = $num + 1;
file_put_contents("baza/all.num","$ok");
file_put_contents("baza/$cid.num","$ok");
file_put_contents("baza/$ok.botext", "$tx");
file_put_contents("baza/$ok.admin",$cid);
unlink("step/$cid.txt");
bot("SendMessage",[
'chat_id'=>$cid,
'text'=>"<b>🧾 Mahsulotingiz sotuvga qo'shildi!</b>",
'parse_mode'=>'html',
'reply_markup'=>$main_menu,
]);
unlink("step/$cid.txt");
}}}

if($data=="sotib_olish" and joinchat($ccid)=="true"){
$array = rand(1,$num);
$bk = $array - 1;
$ali=file_get_contents("baza/$array.botext");
if($ali){
$caption = file_get_contents("baza/$array.botext");
$ega= file_get_contents("baza/$array.admin");
bot("deletemessage",[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot("sendPhoto",[
'chat_id'=>$ccid,
'photo'=>"https://t.me/botim1chi/440",
'caption'=>"Elon raqam: $array | $soat

<b>$caption</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true, 
'inline_keyboard'=>[
[['text'=>"☎️ Murojat",url=>"tg://user?id=$ega"]],
[['text'=>"️⏪ Qaytish",'callback_data'=>"next=$bk"],['text'=>"️⏩ O'tkazish",'callback_data'=>"next=$array"]],
[['text'=>"🏠 Menyu",'callback_data'=>"men"]],
]])
]);
}else{
bot("answerCallbackQuery",[
"callback_query_id"=>$callid,
"text"=>"⚠️ Sotuvga qo'yilgan mahsulotlar topilmadi...",
"show_alert"=>true,
]);
}}

if(mb_stripos($data,"next=")!==false){
$next = explode("=",$data)[1];
$nex = $next + 1;
$bk = $next - 1;
$ali2=file_get_contents("baza/$nex.botext");
if($ali2){
$caption = file_get_contents("baza/$nex.botext");
$ega= file_get_contents("baza/$nex.admin");
bot("deletemessage",[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot("sendPhoto",[
'chat_id'=>$ccid,
'photo'=>"https://t.me/botim1chi/440",
'caption'=>"Elon raqam: $nex | $soat

<b>$caption</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true, 
'inline_keyboard'=>[
[['text'=>"☎️ Murojat",url=>"tg://user?id=$ega"]],
[['text'=>"️⏪ Qaytish",'callback_data'=>"next=$bk"],['text'=>"️⏩ O'tkazish",'callback_data'=>"next=$nex"]],
[['text'=>"🏠 Menyu",'callback_data'=>"men"]],
]])
]);
}else{
bot("answerCallbackQuery",[
"callback_query_id"=>$callid,
"text"=>"⚠️ Boshqa mahsulotlar topilmadi...",
"show_alert"=>true,
]);
}}

if($text == "➕ Yangi kod olish" and joinchat($cid)==true){
$kategoriya = file_get_contents("sozlamalar/bot/kategoriya.txt");
$more = explode("\n",$kategoriya);
$soni = substr_count($kategoriya,"\n");
$key=[];
for ($for = 1; $for <= $soni; $for++) {
$title = str_replace("\n","",$more[$for]);
$key[]=["text"=>"$title","callback_data"=>"bolim-$title"];
$keyboard2 = array_chunk($key, 2);
$bolim = json_encode([
'inline_keyboard'=>$keyboard2,
]);
}
if($kategoriya == null){
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>⚠️ Kategoriyalar mavjud emas!</b>",
'parse_mode'=>'html',
]);
exit();
}else{
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"📋 <b>Quyidagi bo‘limlardan birini tanlang:</b>",
'parse_mode'=>'html',
'reply_markup'=>$bolim,
]);
exit();
}}

if($data == "orqaga" and joinchat($ccid)=="true"){
$more = explode("\n",$kategoriya);
$soni = substr_count($kategoriya,"\n");
$key=[];
for ($for = 1; $for <= $soni; $for++) {
$title = str_replace("\n","",$more[$for]);
$key[]=["text"=>"$title","callback_data"=>"bolim-$title"];
$keyboard2 = array_chunk($key, 2);
$bolim = json_encode([
'inline_keyboard'=>$keyboard2,
]);
}
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"📋 <b>Quyidagi bo‘limlardan birini tanlang:</b>",
'parse_mode'=>"html",
'reply_markup'=>$bolim,
]);
exit();
}

if(mb_stripos($data, "bolim-")!==false){
$ex = explode("-",$data);
$kat = $ex[1];
$royxat = file_get_contents("sozlamalar/bot/$kat/royxat.txt");
$kategoriya = file_get_contents("sozlamalar/bot/kategoriya.txt");
$more = explode("\n",$royxat);
$soni = substr_count($royxat,"\n");
$keys=[];
for ($for = 1; $for <= $soni; $for++) {
$title=str_replace("\n","",$more[$for]);
$keys[]=["text"=>"🤖 $title","callback_data"=>"botyarat-$title-$kat"];
$keysboard2 = array_chunk($keys, 1);
$keysboard2[] = [['text'=>"◀️ Orqaga",'callback_data'=>"orqaga"]];
$key = json_encode([
'inline_keyboard'=>$keysboard2,
]);
}
if($royxat != null){
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"🤖 <b>Quyidagi botlardan birini tanlang:</b>",
'parse_mode'=>'html',
'reply_markup'=>$key,
]);
}else{
bot('answerCallbackQuery',[
'callback_query_id'=>$callid,
'text'=>"📂 Botlar mavjud emas!",
'show_alert'=>true,
]);
}
}

if(mb_stripos($data, "botyarat-")!==false){
$bots=file_get_contents("foydalanuvchi/bot/$cid/bots.txt");
$ex = explode("-",$data);
$royxat = $ex[1];
$kategoriya = $ex[2];
$type = file_get_contents("sozlamalar/bot/$kategoriya/$royxat/turi.txt");
$narx = file_get_contents("sozlamalar/bot/$kategoriya/$royxat/narx.txt");
$tavsif = file_get_contents("sozlamalar/bot/$kategoriya/$royxat/tavsif.txt");
$botkodi = file_get_contents("sozlamalar/bot/$kategoriya/$royxat/url.txt");
$caption = file_get_contents("sozlamalar/bot/$kategoriya/$royxat/caption.txt");
if($bots){
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"<b>🤖 $type</b>

<b>💬 Bot tili:</b> O'zbekcha
<b>💵 Kod narxi:</b> $narx $pul

📋 <b>Qo'shimcha ma'lumot:</b> <i>$tavsif</i>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"✅ Olish",'callback_data'=>"botbor"]],
[['text'=>"◀️ Orqaga",'callback_data'=>"bolim-$kategoriya"]],
]])
]);
}else{
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"<b>🤖 $type</b>

<b>💬 Bot tili:</b> O'zbekcha
<b>💵 Kod narxi:</b> $narx $pul

📋 <b>Qo'shimcha ma'lumot:</b> <i>$tavsif</i>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"✅ Olish",'callback_data'=>"bots-$type-$narx-$royxat-$kategoriya"]],
[['text'=>"◀️ Orqaga",'callback_data'=>"bolim-$kategoriya"]],
]])
]);
}}

if($data =="botbor"){
bot("answerCallbackQuery",[
'callback_query_id'=>$callid,
'text'=>"⚠️ Sizda aktiv bot mavjud!",
'show_alert'=>true,
]);
}

if(mb_stripos($data, "bots-")!==false){
$ex = explode("-",$data);
$turi = $ex[1];
$narx = $ex[2];
$royxat = $ex[3];
$kategoriya = $ex[4];
$olish = file_get_contents("foydalanuvchi/hisob/$ccid.txt");
$olish -= $narx;
file_put_contents("foydalanuvchi/hisob/$ccid.txt", $olish);
$botkodi = file_get_contents("sozlamalar/bot/$kategoriya/$royxat/url.txt");
$captionnin = file_get_contents("sozlamalar/bot/$kategoriya/$royxat/caption.txt");
$get = file_get_contents("foydalanuvchi/hisob/$ccid.txt");
if($get < $narx){
$pul = file_get_contents("foydalanuvchi/hisob/$ccid.txt");
$mm=$pul-$narx;
file_put_contents("foydalanuvchi/hisob/$ccid.txt","$mm");
$fid = $message->from->id;
$cid = $message->chat->id;
$kanalim = "@Qiziq_Coders";
$name = $message->from->first_name;
file_put_contents("foydalanuvchi/hisob/$cid.txt", $olish);
bot("answerCallbackQuery",[
'callback_query_id'=>$callid,
'text'=>"⚠️ Hisobingizda mablag' yetarli emas",
'show_alert'=>true,
]);
}else{
bot('sendmessage',[
'chat_id'=>$admin,
'text'=>"<b>Foydalanuvchi kod oldi
👮‍♂️ Foydalanuvchi:</b> $callname
👤 Foydalanuvchi useri: @$calluser
🔎 <b>ID raqami:</b> $ccid
📮 Kod: $turi
💰 Kod narxi: $narx
/Onn_$narx_$ccid",
'parse_mode'=>"html",
]);
bot('sendmessage',[
'chat_id'=>$kanalim,
'text'=>"<b>Foydalanuvchi kod oldi
👮‍♂️ Foydalanuvchi:</b> $callname
👤 Foydalanuvchi useri: @$calluser
🔎 <b>ID raqami:</b>  <code>$ccid</code>
📮 Kod: $turi
💰 Kod narxi: $narx

🔊 Holati: ✔",
'parse_mode'=>"html",
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"$botkodi",
'caption'=>"<b>$captionnin</b>",
'parse_mode'=>"html",
]);
bot('sendmessage',[
'chat_id'=>$admin,
'text'=>"<b>nima qilay</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"oldiku",'callback_data'=>"kodm"]],
]])
]);
unlink("step/$cid.txt");
}}

if(mb_stripos($userstep, "bots&token-")!==false){
$ex = explode("-",$userstep);
$turi = $ex[1];
$narx = $ex[2];
$nomi = $ex[3];
$kategoriya = $ex[4];
if(mb_stripos($tx, ":")!==false){
$getid = bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>✅ Siz yuborgan bot tokeni qabul qilindi!</b>",
'parse_mode'=>'html',
])->result->message_id;
$botuser = json_decode(file_get_contents("https://api.telegram.org/bot$tx/getme"))->result->username;
$kod = file_get_contents("botlar/$turi.php");
$kod = str_replace("API_TOKEN", "$tx", $kod);
$kod = str_replace("ADMIN_ID", "$fid", $kod);

mkdir("foydalanuvchi/bot/$cid");
file_put_contents("foydalanuvchi/bot/$cid/$turi.php", $kod);

$get = json_decode(file_get_contents("https://api.telegram.org/bot$tx/setwebhook?url=https://".$_SERVER['SERVER_NAME']."/ORGBuilder/foydalanuvchi/bot/$cid/$turi.php"))->result;

if($get){
$botuser = json_decode(file_get_contents("https://api.telegram.org/bot$tx/getme"))->result->username;
$nomi = json_decode(file_get_contents("https://api.telegram.org/bot$tx/getme"))->result->first_name;
$id = json_decode(file_get_contents("https://api.telegram.org/bot$tx/getme"))->result->id;
mkdir("foydalanuvchi/bot/$cid");
$soat = date("H:i",strtotime("2 hour"));
$kun = date("d.m.y",strtotime("2 hour"));
file_put_contents("foydalanuvchi/bot/$cid/soat.txt","$soat");
file_put_contents("foydalanuvchi/bot/$cid/kunida.txt","$kun");
file_put_contents("foydalanuvchi/bot/$cid/token.txt","$tx");
file_put_contents("foydalanuvchi/bot/$cid/botholat.txt","activ");
file_put_contents("foydalanuvchi/bot/$cid/turi.txt","$turi");
file_put_contents("foydalanuvchi/bot/$cid/bots.txt");
if(isset($message)){
$bots=file_get_contents("foydalanuvchi/bot/$cid/bots.txt");
if(mb_stripos($bots,$botuser)==false){
file_put_contents("foydalanuvchi/bot/$cid/bots.txt", "$bots\n$botuser");
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>➕ Yangi bot yaratildi!</b>

🧾 <b>Bot turi</b>: $turi
🔎 <b>Bot useri</b>: @$botuser",
'parse_mode'=>"html",
]);
sleep(0.5);
bot('deleteMessage',[
'chat_id'=>$cid,
'message_id'=>$mid,
]);
sleep(1);
bot('editMessageText',[
'chat_id'=>$cid,
'message_id'=>$getid,
'text'=>"<b>ℹ️ Botingiz tayyor. Quyidagi tugma orqali botingizga o'tishingiz mumkin.</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"➡️ Botga o'tish",'url'=>"https://t.me/$botuser"]],
[['text'=>"◀️ Orqaga",'callback_data'=>"orqagauz"]],
]])
]);
$pul = file_get_contents("foydalanuvchi/hisob/$cid.txt");
$f=$pul/200;
date_default_timezone_set('Asia/Tashkent');
$t=date("d");
$d['sana']=$t;
$d['kun']=10;
$d['puli']=2000;
file_put_contents("foydalanuvchi/bot/$cid/kunlik.tolov",json_encode($d));
$gett = file_get_contents("foydalanuvchi/hisob/$cid.txt");
$gett -= $narx;
file_put_contents("foydalanuvchi/hisob/$cid.txt", $gett);
$aktivbot = file_get_contents("statistika/aktivbot.txt");
$aktivbot += 1;
file_put_contents("statistika/aktivbot.txt", $aktivbot);
$hammabot = file_get_contents("statistika/hammabot.txt");
$hammabot += 1;
file_put_contents("statistika/hammabot.txt", $hammabot);
$botkodi = file_get_contents("sozlamalar/bot/$kategoriya/$royxat/url.txt");
}}}
unlink("step/$cid.txt");
}else{
bot('senddocument',[
'chat_id'=>$cid,
'document'=>$botkodi,
'caption'=>"<b>haha jala</b>",
'parse_mode'=>"html",
]);
unlink("step/$cid.txt");
}
unlink("step/$ccid.txt");
}

if($tx=="$tugma2" and joinchat($fid)=="true"){
$odam=file_get_contents("foydalanuvchi/referal/$cid.txt");
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>🔎 ID raqamingiz:</b> <code>$cid</code>

<b>💵 Asosiy balans:</b> $asosiy $pul
<b>🏦 Qo'shimcha balans:</b> $sar $pul
<b>🔗 Takliflaringiz:</b> $odam ta

<b>💳 Botga kiritgan pullaringiz:</b> $kiritgan $pul",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🔁 O'tkazmalar",'callback_data'=>"puliz"]],
[['text'=>"💳 Hisobni to'ldirish",'callback_data'=>"oplata"]],
]])
]);
}

if($data == "orqaga12" and joinchat($ccid)=="true"){
$hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");
$kiritgan = file_get_contents("foydalanuvchi/hisob/$ccid.1.txt");
$sar = file_get_contents("foydalanuvchi/hisob/$ccid.1txt");
$odam=file_get_contents("foydalanuvchi/referal/$ccid.txt");
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('SendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>🔎 ID raqamingiz:</b> <code>$ccid</code>

<b>💵 Asosiy balans:</b> $hisob $pul
<b>🏦 Qo'shimcha balans:</b> $sar $pul
<b>🔗 Takliflaringiz:</b> $odam ta

<b>💳 Botga kiritgan pullaringiz:</b> $kiritgan $pul",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🔁 O'tkazmalar",'callback_data'=>"puliz"]],
[['text'=>"💳 Hisobni to'ldirish",'callback_data'=>"oplata"]],
]])
]);
}

if($tx == "◀️ Orqaga" and joinchat($fid)=="true"){
if($cid==$admin){
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>🖥 Asosiy menyuga qaytdingiz</b>",
'parse_mode'=>"html",
'reply_markup'=>$main_menuad,
]);
unlink("step/$cid.txt");
unlink("step/$cid.txt1");
}else{
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>🖥 Asosiy menyuga qaytdingiz</b>",
'parse_mode'=>"html",
'reply_markup'=>$main_menu,
]);
unlink("step/$cid.txt");
unlink("step/$cid.txt1");
}}

if($data == "puliz" and joinchat($ccid)=="true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('SendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>Kerakli foydalanuvchi ID raqamini yuboring:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"◀️ Orqaga"]]
]])
]);
file_put_contents("step/$ccid.txt","perevodid");
}
if($userstep == "perevodid" and $tx !== "◀️ Orqaga" and joinchat($fid)=="true"){
file_put_contents("otkazma/$fid.idraqam","$tx");
unlink("step/$cid.txt");
$getid = bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Qancha mablag'ingizni o'tkazmoqchisiz?

Hisobingiz:</b> $asosiy $pul",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"◀️ Orqaga"]]
]])
]);

file_put_contents("step/$cid.txt","perevodid1");
}
if($userstep == "perevodid1" and $tx !== "◀️ Orqaga" and joinchat($fid)=="true"){
file_put_contents("otkazma/$cid.pulraqam","$tx");
$raqamid = file_get_contents("otkazma/$cid.idraqam");
$raqapul = file_get_contents("otkazma/$cid.pulraqam");
$olmos1 = file_get_contents("foydalanuvchi/hisob/$raqamid.txt");
$olmos2 = file_get_contents("foydalanuvchi/hisob/$cid.txt");
$csful = $raqapul / 1 * 1;
if($olmos2>=$csful and $tx>=0){
$olmoslar1 = $olmos1 + $raqapul;
$olmoslar2 = $olmos2 - $csful;

file_put_contents("foydalanuvchi/hisob/$raqamid.txt","$olmoslar1");
file_put_contents("foydalanuvchi/hisob/$cid.txt","$olmoslar2");
bot("sendMessage",[
"chat_id"=>$raqamid,
"text"=>"<b>Hisobingizga</b> <a href='tg://user?id=$cid'>$cid</a><b> tomonidan $tx $pul o'tkazdi.</b>",
'parse_mode'=>'html',
]);
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>✅ O'tkazma muvaffaqiyatli amalga oshirildi!</b>",
'parse_mode'=>'html',
]);
unlink("step/$cid.txt");
}else{
bot("sendMessage",[
"chat_id"=>$cid,
"text"=>"<b>⚠️ Hisobingizda mablag' yetarli emas!</b>",
'parse_mode'=>'html',
]);
}}

if($data=="oplata" and joinchat($ccid)==true){
$kategoriya = file_get_contents("sozlamalar/hamyon/kategoriya.txt");
$more = explode("\n",$kategoriya);
$soni = substr_count($kategoriya,"\n");
$key=[];
for ($for = 1; $for <= $soni; $for++) {
$title = str_replace("\n","",$more[$for]);
$key[]=["text"=>"$title","callback_data"=>"karta-$title"];
$keyboard2 = array_chunk($key, 1);
$keyboard2[] = [['text'=>"◀️ Orqaga",'callback_data'=>"orqaga12"]];
$bolim = json_encode([
'inline_keyboard'=>$keyboard2,
]);
}
if($kategoriya == null){
bot("answerCallbackQuery",[
"callback_query_id"=>$callid,
"text"=>"⚠️ To'lov tizimlari qo'shilmagan!",
"show_alert"=>true,
]);
}else{
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"<b>💳 Quyidagi to'lov tizimlaridan birini tanlang:</b>",
'parse_mode'=>'html',
'reply_markup'=>$bolim,
]);
exit();
}}

if(mb_stripos($data, "karta-")!==false){
$ex = explode("-",$data);
$kategoriya = $ex[1];
$raqam = file_get_contents("sozlamalar/hamyon/$kategoriya/raqam.txt");
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"<b>📲 To‘lov turi:</b> <u>$kategoriya</u>

💳 Karta: <code>$raqam</code>
📝 Izoh: #ID$ccid

Almashuvingiz muvaffaqiyatli bajarilishi uchun quyidagi harakatlarni amalga oshiring: 
1) Istalgan pul miqdorini tepadagi Hamyonga tashlang
2) «✅ To'lov qildim» tugmasini bosing; 
4) Qancha pul miqdoni yuborganingizni kiritin;
3) Toʻlov haqidagi suratni botga yuboring;
3) Operator tomonidan almashuv tasdiqlanishini kuting!",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"✅ To'lov qildim",'callback_data'=>"tolov"]],
[['text'=>"◀️ Orqaga",'callback_data'=>"oplata"]],
]])
]);
}

if($data == "tolov" and joinchat($ccid)=="true"){
bot('DeleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('SendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>To'lov miqdorini kiriting:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"◀️ Orqaga"]],
]])
]);
file_put_contents("step/$ccid.txt",'oplata');
}

// ESKI (XATO) VARIANT:
/* if($userstep == "oplata" and joinchat($ccid)=="true"){
if($tx=="◀️ Orqaga"){
unlink("step/$cid.txt");
}else{
file_put_contents("step/hisob.$cid",$text);
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>To'lovingizni chek yoki skreenshotini shu yerga yuboring:</b>",
'parse_mode'=>'html',
]);
file_put_contents("step/$cid.txt",'rasm');
}}
*/

// YANGI (TO'G'RI) VARIANT:
if($userstep == "oplata" and joinchat($cid)){ // "==true" shart emas, lekin turaversa ham bo'ladi
    if($tx == "◀️ Orqaga"){
        unlink("step/$cid.txt");
    }else{
        // Faqat raqam kiritilishini tekshirish uchun qo'shimcha himoya (ixtiyoriy)
        if(is_numeric($text)){
            file_put_contents("step/hisob.$cid", $text);
            bot('SendMessage',[
                'chat_id'=>$cid,
                'text'=>"<b>To'lovingizni chek yoki skreenshotini shu yerga yuboring:</b>",
                'parse_mode'=>'html',
            ]);
            file_put_contents("step/$cid.txt",'rasm');
        } else {
             bot('SendMessage',[
                'chat_id'=>$cid,
                'text'=>"<b>Iltimos, faqat raqam kiriting!</b>",
                'parse_mode'=>'html',
            ]);
        }
    }
}

if($userstep == "rasm"){
if($cid==$admin){
if($tx=="◀️ Orqaga"){
unlink("step/$fid.txt");
}else{
$photo = $message->photo;
$file = $photo[count($photo)-1]->file_id;
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"*Hisobni to'ldirganingiz haqida ma'lumot asosiy adminga yuborildi. Agar to'lovni amalga oshirganingiz haqida ma'lumot mavjud bo'lsa, hisobingiz to'ldiriladi.*",
'parse_mode'=>'MarkDown',
'reply_markup'=>$main_menuad,
]);
$hisob=file_get_contents("step/hisob.$fid");
unlink("step/$fid.txt");
bot('sendPhoto',[
'chat_id'=>$admin,
'photo'=>$file,
'caption'=>"📄 <b>Foydalanuvchidan check:

👮‍♂️ Foydalanuvchi:</b> <a href='https://tg://user?id=$cid'>$name</a>
🔎 <b>ID raqami:</b> $fid
💵 <b>To'lov miqdori:</b> $hisob $pul",
'disable_web_page_preview'=>true,
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"✅ Hisobini to'ldirish",'callback_data'=>"on=$fid"]],
[['text'=>"❌ Bekor qilish",'callback_data'=>"off=$fid"]],
]])
]);
}}else{
if($tx=="◀️ Orqaga"){
unlink("step/$fid.txt");
}else{
$photo = $message->photo;
$file = $photo[count($photo)-1]->file_id;
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"*Hisobni to'ldirganingiz haqida ma'lumot asosiy adminga yuborildi. Agar to'lovni amalga oshirganingiz haqida ma'lumot mavjud bo'lsa, hisobingiz to'ldiriladi.*",
'parse_mode'=>'MarkDown',
'reply_markup'=>$main_menu,
]);
$hisob=file_get_contents("step/hisob.$fid");
unlink("step/$fid.txt");
bot('sendPhoto',[
'chat_id'=>$admin,
'photo'=>$file,
'caption'=>"📄 <b>Foydalanuvchidan check:

👮‍♂️ Foydalanuvchi:</b> <a href='https://tg://user?id=$cid'>$name</a>
🔎 <b>ID raqami:</b> $fid
💵 <b>To'lov miqdori:</b> $hisob $pul",
'disable_web_page_preview'=>true,
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"✅ Hisobini to'ldirish",'callback_data'=>"on=$fid"]],
[['text'=>"❌ Bekor qilish",'callback_data'=>"off=$fid"]],
]])
]);
}}}

if(mb_stripos($data,"on=")!==false){
$odam=explode("=",$data)[1];
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
$hisob=file_get_contents("step/hisob.$odam");
bot('SendMessage',[
'chat_id'=>$odam,
'text'=>"<b>Hisobingiz $hisob $pul ga to'ldirildi</b>",
'parse_mode'=>'html',
]);
$currency=file_get_contents("foydalanuvchi/hisob/$odam.1.txt");
$get = file_get_contents("foydalanuvchi/hisob/$odam.txt");
$get += $hisob;
$currency += $hisob;
file_put_contents("foydalanuvchi/hisob/$odam.txt",$get);
file_put_contents("foydalanuvchi/hisob/$odam.1.txt",$currency);
bot('SendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Foydalanuvchi hisobi $hisob $pul ga to'ldirildi</b>",
'parse_mode'=>'html',
]);
unlink("step/hisob.$odam");
}

if(mb_stripos($data,"off=")!==false){
$odam=explode("=",$data)[1];
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
$hisob=file_get_contents("step/hisob.$odam");
bot('SendMessage',[
'chat_id'=>$odam,
'text'=>"<b>Hisobingizni $hisob $pul ga to'ldirish bekor qilindi</b>",
'parse_mode'=>'html',
]);
bot('SendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Foydalanuvchi cheki bekor qilindi</b>",
'parse_mode'=>'html',
]);
unlink("step/hisob.$odam");
}

if($tx=="$tugma3" and joinchat($fid)=="true"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>📋 Quyidagilardan birini tanlang:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"$tugma7",'callback_data'=>"taklifnoma"]],
]])
]);
}

if($data == "orqaga3" and joinchat($ccid)=="true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('SendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>📋 Quyidagilardan birini tanlang:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"$tugma7",'callback_data'=>"taklifnoma"]],
]])
]);
}

if($data == "taklifnoma" and joinchat($ccid)=="true"){
$odam=file_get_contents("foydalanuvchi/referal/$ccid.txt");
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>🔗 Sizning taklif havolangiz:</b>

<code>https://t.me/$botname?start=$ccid</code>

<b>1 ta taklif uchun $taklifpul so'm beriladi

Sizning takliflaringiz: $odam ta</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"👥 Do'stlarga yuborish",'url'=>"https://t.me/share/url?url=https://t.me/$botname?start=$ccid"]],
[['text'=>"◀️ Orqaga",'callback_data'=>"orqaga3"]],
]])
]);
}

if($text=="$tugma4" and joinchat($cid)==true){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>📝 Murojaat matnini yuboring:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"◀️ Orqaga"]],
]])
]);
file_put_contents("step/$cid.txt","murojat");
}

if($data=="boglanish" and joinchat($ccid)==true){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>📝 Murojaat matnini yuboring:</b>
Siz ham o'z biznesingizni boshlang bizning bot bilan @zero_builder_bot",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"◀️ Orqaga"]],
]])
]);
file_put_contents("step/$ccid.txt","murojat");
}

if($userstep=="murojat"){
if($text=="◀️ Orqaga"){
unlink("step/$cid.txt");
}else{
file_put_contents("step/$cid.murojat","$cid");
$murojat=file_get_contents("step/$cid.murojat");
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>📨 Yangi murojat keldi:</b> $murojat

<b>📑 Murojat matni:</b> $text

<b>⏰ Kelgan vaqti:</b> $soat",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Javob yozish",'callback_data'=>"yozish=$murojat"]],
]])
]);
unlink("step/$murojat.txt");
if($cid==$admin){
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>✅ Murojaatingiz yuborildi.</b>

<i>Tez orada javob qaytaramiz!</i>",
'parse_mode'=>'html',
'reply_markup'=>$main_menuad,
]);
}else{
bot('sendMessage',[
'chat_id'=>$murojat,
'text'=>"<b>✅ Murojaatingiz yuborildi.</b>

<i>Tez orada javob qaytaramiz!</i>",
'parse_mode'=>'html',
'reply_markup'=>$main_menu,
]);
}}}

if(mb_stripos($data,"yozish=")!==false){
$odam=explode("=",$data)[1];
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>Javob matnini yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"◀️ Orqaga"]],
]])
]);
file_put_contents("step/$ccid.txt","javob");
file_put_contents("step/$ccid.javob","$odam");
}

if($userstep=="javob"){
if($tx=="◀️ Orqaga"){
unlink("step/$admin.step");
unlink("step/$admin.javob");
}else{
$murojat=file_get_contents("step/$cid.javob");
bot('sendMessage',[
'chat_id'=>$murojat,
'text'=>"<b>☎️ Administrator:</b>

<i>$text</i>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"Javob yozish",'callback_data'=>"boglanish"]],
]])
]);
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Javob yuborildi</b>",
'parse_mode'=>"html",
'reply_markup'=>$main_menuad,
]);
unlink("step/$murojat.murojat");
unlink("step/$admin.step");
unlink("step/$admin.javob");
}}

/*if($tx == "📩 Reklama Xizmati" and $cid == $admin){*/
if($text=="📩 Reklama Xizmati" and joinchat($cid)==true){
	$lichka=file_get_contents("statistika/obunachi.txt");
$lich=substr_count($lichka,"\n");
$load = sys_getloadavg();
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"@$botname - bizning botimizda reklama berish xizmati ❗

🤖 Bot foydalanuvchilari: $lich nafar
📋 Reklama berish",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"👨‍💻 Bog'lanish",'url'=>"https://t.me/$admin"]],
[['text'=>"🤖 Bot ochish",'url'=>"https://t.me/SealChannel"]],
]])
]);
}


?>


