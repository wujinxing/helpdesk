<div id="calldetails">
  <h2>Ticket details #<?php echo $ticketDetails["callid"]; ?></h2>
  <table class="noborder">
    <tr>
      <td>
        <?php if (@getimagesize(PROFILE_IMAGES.strtolower($ticketDetails["owner"]).".jpg")) {
          // check profile image exists for user
          echo "<img src=\"".PROFILE_IMAGES.strtolower($ticketDetails["owner"]).".jpg"."\" alt=\"default profile picture\" class=\"profile-picture\" />";
        } else {
          // display default placeholder
          echo "<img src=\"/uploads/profile_images/default.jpg\" alt=\"default profile picture\" class=\"profile-picture\" />";
        }?>
      </td>
      <td>
        <p class="callheader"><span class="nowrap">Created by:</span>       <span class="nowrap"><?php echo $ticketDetails["name"];?></span></p>
        <p class="callheader"><span class="nowrap">Contact number:</span>   <span class="nowrap"><?php echo $ticketDetails["tel"];?></span></p>
        <p class="callheader"><span class="nowrap">Location:</span>         <span class="nowrap"><?php echo $ticketDetails["locationName"];?></span></p>
        <p class="callheader"><span class="nowrap">Room:</span>             <span class="nowrap"><?php echo $ticketDetails["room"];?></span></p>
        <p class="callheader"><span class="nowrap">Category:</span>         <span class="nowrap"><?php echo $ticketDetails["categoryName"];?></span></p>
        <p class="callheader"><span class="nowrap">Assigned to:</span>      <span class="nowrap"><?php echo $ticketDetails["engineerName"];?></span></p>
        <p class="callheader"><span class="nowrap">Opened:</span>           <span class="nowrap"><?php echo date("d/m/Y H:i", strtotime($ticketDetails["opened"]));?></span></p>
        <p class="callheader"><span class="nowrap">Closed:</span>           <span class="nowrap"><?php if ($ticketDetails["closed"]) {echo date("d/m/Y H:i", strtotime($ticketDetails["closed"])); } ?></span></p>
        <p class="callheader"><span class="nowrap">Ticket Age:</span>       <span class="nowrap"><?php echo $ticketDetails["daysold"];?> day(s)</span></p>
        <p class="callheader"><span class="nowrap">Scheduled Ticket:</span> <span class="nowrap"><?php echo $ticketDetails["pm"] == true ? 'Yes' : 'No'; ?></span></p>
        <p class="callheader"><span class="nowrap">Urgency:</span>          <span class="nowrap"><img src="/public/images/ICONS-urgency<?php echo $ticketDetails["urgency"];?>.svg" alt="<?php echo $ticketDetails["urgency"];?>" title="<?php echo $ticketDetails["urgency"];?>" style="height: 14px; width: 100px" /></span></p>
        <p class="callheader"><span class="nowrap">Locker:</span>           <span class="nowrap"><?php echo $ticketDetails["lockerid"];?></span></p>
      </td>
    </tr>
  </table>

  <h3 class="callbody"><?php echo $ticketDetails["title"];?></h3>
    <p class="callbody">
      <ul><?php foreach ($additionalDetails as $key => $value) { echo "<li>" . $value["label"] .": ". $value["value"] . "</li>"; } ?></ul>
    </p>
    <p class="callbody"><?php echo nl2br($ticketDetails["details"]);?></p>

    <p class="highlight smalltxt">Last Update: <?php echo date("d/m/Y H:i", strtotime($ticketDetails["lastupdate"]));?></p>

    <form action="/ticket/update/" method="post" enctype="multipart/form-data" id="updateForm">
      <input type="hidden" id="id" name="id" value="<?php echo $ticketDetails["callid"]; ?>" />
      <input type="hidden" id="contact_email" name="contact_email" value="<?php echo $ticketDetails["email"]; ?>" />
      <input type="hidden" id="button_value" name="button_value" value="" />
      <input type="hidden" id="details" name="details" value="<?php echo htmlspecialchars($ticketDetails["details"]);?>" />
      <fieldset>
        <legend>Update Ticket</legend>
        <p><textarea name="updatedetails" id="updatedetails" rows="10" cols="40"></textarea></p>
        <p><label for="attachment">Picture or Attachment</label><input type="file" name="attachment" accept="application/pdf,application/msword,image/*" style="background-color: transparent;" id="attachment"></p>
        <?php
        // show only for engineers, managers & superusers
        if ($_SESSION['engineerLevel'] >= "1" or $_SESSION['superuser'] === "1") {
        ?>
        <p><label for="callreason">Reason for issue</label>
          <select id="callreason" name="callreason" REQUIRED>
            <option value="" SELECTED>Please Select</option>
            <?php foreach ($callreasons as $key => $value) { ?>
              <option value="<?php echo $value["id"] ?>" <?php if ($ticketDetails["callreason"] == $value["id"]) { echo "SELECTED"; } ?> >
                <?php echo $value["reason_name"] ?>
              </option>
            <?php } ?>
          </select>
        </p>
        <p>
        <label for="quickresponse">Quick Response</label>
          <select id="quickresponse" name="quickresponse">
            <option value="" SELECTED>Please Select</option>
            <?php foreach ($quickresponse as $key => $value) { echo "<option value=\"".$value["quick_response"]."\">".$value["quick_response"]."</option>"; } ?>
          </select>
        </p>
        <?php } ?>
      </fieldset>
      <fieldset>
        <legend>Ticket Controls</legend>
        <div class="buttons">
          <?php
          // show only for managers & superusers
          if ($_SESSION['engineerLevel'] === "2" or $_SESSION['superuser'] === "1") { ?>
          <button name="assign" value="assign" type="submit" onclick="this.form.button_value.value = this.value;">Assign Engineer</button>
          <button name="forward" value="forward" type="submit" onclick="this.form.button_value.value = this.value;">Forward To Helpdesk</button>
          <?php if ($ticketDetails["requireinvoice"] == 1) {?><button name="invoicearrived" value="invoicearrived" type="submit" onclick="this.form.button_value.value = this.value;">Invoice Received</button><?php } else {?><button name="invoice" value="invoice" type="submit" onclick="this.form.button_value.value = this.value;">Require Invoice</button><?php } ?>
          <?php }
          // show only for engineers, managers & superusers
          if ($_SESSION['engineerLevel'] >= "1" or $_SESSION['superuser'] === "1") {
          ?>
          <button name="locker" value="locker" type="submit" onclick="this.form.button_value.value = this.value;">Add to Locker</button>
          <?php if ($ticketDetails["status"] == 5) { ?><button name="return" value="return" type="submit" onclick="this.form.button_value.value = this.value;">Return</button><?php } else { ?><button name="sendaway" value="sendaway" type="submit" onclick="this.form.button_value.value = this.value;">Send Away</button><?php } ?>
          <?php if ($ticketDetails["status"] == 4) { ?><button name="deescalate" value="deescalate" type="submit" onclick="this.form.button_value.value = this.value;">de-Escalate</button><?php } else { ?><button name="escalate" value="escalate" type="submit" onclick="this.form.button_value.value = this.value;">Escalate</button><?php } ?>
          <?php if ($ticketDetails["status"] == 3) { ?><button name="unhold" value="unhold" type="submit" onclick="this.form.button_value.value = this.value;">un-Hold</button><?php } else { ?><button name="hold" value="hold" type="submit" onclick="this.form.button_value.value = this.value;">Hold</button><?php } ?>
          <button name="close" value="close" type="submit" onclick="this.form.button_value.value = this.value;">Close</button>
          <?php } ?>
          <button name="update" value="update" type="submit" onclick="this.form.button_value.value = this.value;">Update</button>
          <?php if ($ticketDetails["status"] == 2 or $_SESSION['engineerLevel'] != 1) {?>
          <button name="feedback" value="feedback" type="submit" onclick="this.form.button_value.value = this.value;">Leave Feedback</button>
          <?php } ?>
        </div>
      </fieldset>
    </form>
    <script>
      $("#updateForm").validate();
      $("#quickresponse").change(function(e) {
      $('#updatedetails').val($('#quickresponse').val() + ', ' + $('#updatedetails').val());
      });
    </script>
</div>