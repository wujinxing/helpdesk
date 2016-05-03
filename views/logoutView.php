<?php require_once "views/partials/header.php"; ?>

  <div id="leftpage">
    <br />
    <h3>Did you know</h3>
    <br/>
    <p>
      You have logged <span class="logoutstats"><?php echo number_format($stats["countTicketsByOwner"]) ?></span> tickets on the helpdesk
    </p>
    <p>
      Total tickets logged by users <span class="logoutstats"><?php echo number_format($stats["countAllTickets"]) ?></span>
    </p>
    <p>
      Open outstanding tickets on helpdesk <span class="logoutstats"><?php echo number_format($stats["countAllOpenTickets"]) ?></span>
    </p>
    <p>
      Average feedback for tickets on helpdesk is <span class="logoutstats"><?php echo round($stats["FeedbackAVG"],2)?></span> <?php for ($i = 0; $i < round($stats["FeedbackAVG"]); $i++) { echo "<img src='/public/images/ICONS-star.svg' alt='star' height='24' width='auto' />"; } ?>
    </p>
    <ul>
    <?php
      foreach($stats["avgInDays"] as $key => $value) {
        echo "<li>" . $value["helpdesk_name"] . " on average take <span class=\"logoutstats\">" . number_format($value["avg_days"], 1) . "</span> days to close a ticket.</li>";
      }
    ?>
    </ul>
  </div>
  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h2>Good Bye</h2>
        <p>You have sucessfully logged out of <?php echo CODENAME ?>, see you soon!</p>
      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
