<?php if ($showPayment): ?>
  <div class="wrapper" style="margin-top: 1rem;">
    <h1>Payment Details</h1>
    <p><strong>Park:</strong> <?php echo htmlspecialchars($bookingData['park']); ?></p>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($bookingData['name']); ?></p>
    <p><strong>Contact:</strong> <?php echo htmlspecialchars($bookingData['phone']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($bookingData['email']); ?></p>
    <p><strong>Persons:</strong> <?php echo htmlspecialchars($bookingData['persons']); ?></p>
    <p><strong>Total Amount:</strong> <?php echo htmlspecialchars($bookingData['total']); ?></p>
    <p><strong>Booking Date:</strong> <?php echo htmlspecialchars($bookingData['date']); ?></p>

    <hr>

    <h2 style="font-size:1.2rem; color:#2e7d32;">Select Payment Method</h2>
    <form method="post" action="">
      <label>
        <input type="radio" name="payment_method" value="upi" required> UPI
      </label><br>
      <label>
        <input type="radio" name="payment_method" value="card"> Credit / Debit Card
      </label><br>
      <label>
        <input type="radio" name="payment_method" value="netbanking"> Net Banking
      </label><br><br>

      <button type="submit" style="padding:.7rem 1.4rem; border:none; border-radius:8px; background:#2e7d32; color:#fff; font-weight:600; cursor:pointer;">
        Pay Now
      </button>
    </form>
  </div>
<?php endif; ?>
</body>
</html>
