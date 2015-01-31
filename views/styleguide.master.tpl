<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    {asset name="Head"}
    <meta name="viewport" content="width=device-width">
  </head>
  <body id="{$BodyID}" class="{$BodyClass}">
    <section id="styleguide">
      <div class="styleguide-page-header">
        <div class="styleguide-container">
          <h1>{t c="Styleguide"}</h1>
        </div>
      </div>

      <div class="styleguide-container">
        {asset name="Content"}
      </div>
    </section>

    {asset name="Foot"}
  </body>
</html>
