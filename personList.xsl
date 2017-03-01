<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:xs="http://www.w3.org/2001/XMLSchema"
    xmlns:math="http://www.w3.org/2005/xpath-functions/math"
    exclude-result-prefixes="xs math"
    version="2.0">
    
    <xsl:template match="/">
        
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <title>Personenliste</title>
            </head>
            <body>
                <h1>Anzeige aller Personen der Alchemie-Bestände</h1>
                <xsl:for-each select="//person">
                    <xsl:sort select="sortiername"/>
                    <xsl:call-template name="namensanzeige">
                        <xsl:with-param name="sortiername"><xsl:value-of select="sortiername"/></xsl:with-param>
                        <xsl:with-param name="url"><xsl:value-of select="searchURL"/></xsl:with-param>                        
                    </xsl:call-template>
                    <!--<b><xsl:value-of select="sortiername"/></b>-->
                        <xsl:if test="lebensdaten">&#160;(<xsl:value-of select="lebensdaten"/>)</xsl:if>
                        <xsl:if test="gnd">&#160;<xsl:value-of select="gnd"/></xsl:if>                    
                        <br />
                        <!--<xsl:if test="gnd">
                            <xsl:variable name="gnd" select="gnd"/>
                            <br />
                            <a href="http://d-nb.info/gnd/{$gnd}">DNB</a>&#160;
                            <xsl:for-each select="beaconResults/link">
                                <xsl:call-template name="displayLink">
                                    <xsl:with-param name="text"><xsl:value-of select="substring-before(current(),'#')"/></xsl:with-param>
                                    <xsl:with-param name="link"><xsl:value-of select="substring-after(current(),'#')"/></xsl:with-param>                                    
                                </xsl:call-template>
                            </xsl:for-each>
                        </xsl:if>-->
                </xsl:for-each>
            </body>
        </html>
        
    </xsl:template>
    
    <xsl:template name="namensanzeige">
        <xsl:param name="sortiername"></xsl:param>
        <xsl:param name="url"></xsl:param>
        <a href="{$url}" target="_blank"><xsl:value-of select="$sortiername"/></a>
    </xsl:template>
    
    <xsl:template name="displayLink">
        <xsl:param name="text"></xsl:param>
        <xsl:param name="link"></xsl:param>
        <a href="{$link}"><xsl:value-of select="$text"/></a>&#160;
    </xsl:template>
    
</xsl:stylesheet>