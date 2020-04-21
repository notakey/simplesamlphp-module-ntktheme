<?php
if (!empty($this->data['htmlinject']['htmlContentPost'])) {
    foreach ($this->data['htmlinject']['htmlContentPost'] as $c) {
        echo $c;
    }
}
?>
</div>
</div>
<?php if ($this->configuration->hasValue('footer.tagline')) { ?>
    <div id="footerTagline"><?php echo $this->configuration->getValue('footer.tagline'); ?> </div>
<?php } ?>
<footer class="footer">
    <div class="container">
        <p><small>Copyright © <?php echo date("Y", (is_readable('/var/simplesamlphp/BUILDTS')) ? @trim(file_get_contents('/var/simplesamlphp/BUILDTS')) : time()); ?> Notakey Latvia SIA, v<?php echo $this->configuration->getVersion(); ?></small></p>
    </div>
</footer>
</body>

</html>