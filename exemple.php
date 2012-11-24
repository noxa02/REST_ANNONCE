<?php

/*
 * Unserialize XML for the Web Client
 */


        $xml = '<users>' .
               '  <user handle="schst">Stephan Schmidt</user>' .
               '  <user handle="mj">Martin Jansen</user>' .
               '  <group name="qa">PEAR QA Team</group>' .
               '  <foo id="test">This is handled by the default keyAttribute</foo>' .
               '  <foo id="test2">Another foo tag</foo>' .
               '</users>';

        $options = array(
                         XML_UNSERIALIZER_OPTION_COMPLEXTYPE => 'array',
                         XML_UNSERIALIZER_OPTION_ATTRIBUTE_KEY => array(
                                                                          'user'     => 'handle',
                                                                          'group'    => 'name',
                                                                          '#default' => 'id'
                                                                        )
                        );

        $unserializer = &new XML_Unserializer($options);
        $status = $unserializer->unserialize($xml, false); 

        if (PEAR::isError($status)) {
            echo 'Error: ' . $status->getMessage();
        } else {
            $data = $unserializer->getUnserializedData();
            echo '<pre>';
            print_r($data);
            echo '</pre>';
        }
?>
