<h1>Announcement </h1>
<style type="text/css">
    .form-group {
    margin-bottom: 1rem;
}
label {
    display: inline-block;
    margin-bottom: .5rem;
}
.form-control {
    display: block;
    width: 100%;
    height: calc(1.5em + .75rem + 2px);
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
.btn-primary {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
}
.btn {
    display: inline-block;
    font-weight: 400;
    color: #212529;
    text-align: center;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-color: transparent;
    border: 1px solid transparent;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: .25rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
.form-container{
    width: 60%;
}
.input-color{
    width: auto !important;
}
</style>

<div class="form-container">
 <form>

   <div class="form-group">
     <label for="start_time">Start Time</label>
     <input class="form-control" type="datetime-local" id="start_time" name="start_time">
   </div>

    <div class="form-group">
     <label for="end_time">End Time</label>
     <input class="form-control" type="datetime-local" id="end_time" name="end_time">
   </div>

   <div class="form-group">
     <label for="announcement_content">Announcement Content</label>
     <textarea class="form-control"name="announcement_content" rows="15"></textarea>
   </div>

   <div class="form-group">
     <label for="link_announcement">Announcement Link</label>
     <input type="text" class="form-control" id="link_announcement" placeholder="Announcement Link">
   </div>

    <div class="form-group">
     <label for="background_color">Background Color</label>
      <input type="color" name="background_color" class="form-control input-color" placeholder="Background Color">
   </div>

   <button type="submit" class="btn btn-primary">Save</button>
 </form>
</div>
 