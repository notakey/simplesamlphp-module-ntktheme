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
        <p><small>Copyright © <?php echo date("Y"); ?> Notakey Latvia SIA</small></p>
    </div>
</footer>
</body>

</html>