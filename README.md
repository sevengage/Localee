# Localee
## Translate Expression Engine Date Variables in to a given language.  

Current only supports months, but we will later add support for full language dates.

Wrap your ExpressionEngine Date Variable:

{exp:localee
    language = ""               // Base locale ID of the given language
    format = "%d %F %Y"			// Pass in EE date format format you want returned
}
    {entry_date}
{/exp:localee}

Passing the appropriate Language reference into the language="" parameter.  We currently support the following languages translations.

* de : German
* fr : French
* nl : Dutch
* pl : Polish
* cz : Czech