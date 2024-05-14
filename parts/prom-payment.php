<!--<div class="gc_popup_bg"></div>-->
<div class="gc_popup">
    <div class="gc_popup__body">
        <form class="gc_popup__form_payment">
            <h2 class="gc_popup__title">
                <?php _e('Sign up Now', RAFFLE_DOMAIN); ?>
            </h2>
            <div class="form-body">
                <div class="form-group form-col">
                    <label for="gc_first_name">
                        <?php _e('First name', RAFFLE_DOMAIN); ?>*
                    </label>
                    <input type="text" name="gc_first_name" id="gc_first_name" required>
                </div>
                <div class="form-group form-col">
                    <label for="gc_last_name">
                        <?php _e('Last name', RAFFLE_DOMAIN); ?>*
                    </label>
                    <input type="text" name="gc_last_name" id="gc_last_name" required>
                </div>
                <div class="form-group form-col">
                    <label for="gc_mobile">
                        <?php _e('Mobile number', RAFFLE_DOMAIN); ?>*
                    </label>
                    <input type="tel" name="gc_mobile" id="gc_mobile" required>
                </div>
                <div class="form-group form-col">
                    <label for="gc_state">
                        <?php _e('State', RAFFLE_DOMAIN); ?>*
                    </label>
                    <select name="gc_state" id="gc_state" required>
                        <option value=""><?php _e('Select state', RAFFLE_DOMAIN); ?></option>
                        <option value="act">ACT</option>
                        <option value="nsv">NSW</option>
                        <option value="nt">NT</option>
                        <option value="qld">QLD</option>
                        <option value="sa">SA</option>
                        <option value="tas">TAS</option>
                        <option value="vic">VIC</option>
                        <option value="wa">WA</option>
                    </select>
                </div>
                <div class="form-group form-col">
                    <label for="gc_email">
                        <?php _e('E-mail', RAFFLE_DOMAIN); ?>*
                    </label>
                    <input type="email" name="gc_email" id="gc_email" required>
                </div>

                <div class="form-group">
                    <label for="gc_credit_card">
                        <?php _e('Credit or debit card', RAFFLE_DOMAIN); ?>*
                    </label>
                    <div id="gc_credit_card" class="gc_credit_card"></div>
                </div>
            </div>
            <button>
                <?php _e('Click here to confirm', RAFFLE_DOMAIN); ?>
            </button>
        </form>
    </div>
</div>