<?php
define('XML_FILE', __DIR__ . '/xml/leaderboards.xml');


function getXMLDoc(): DOMDocument {
    $doc = new DOMDocument('1.0', 'UTF-8');
    $doc->preserveWhiteSpace = false;
    $doc->formatOutput = true;

    $doc->validateOnParse = true; 
    
    if (file_exists(XML_FILE)) {
        $doc->load(XML_FILE);
    }
    return $doc;
}


function saveXML($doc): void {
    $doc->save(XML_FILE);
}

function getPlacements(string $gameId): array {
    $doc   = getXMLDoc();
    $xpath = new DOMXPath($doc);
    $nodes = $xpath->query("//game[@id='$gameId']/placements/placement");
    $results = [];

    foreach ($nodes as $node) {
        $results[] = [
            'id'      => $node->getAttribute('id'),
            'imagine' => $xpath->evaluate('string(imagine)', $node),
            'scor'    => $xpath->evaluate('string(scor)', $node),
            'nume'    => $xpath->evaluate('string(nume)', $node),
        ];
    }

    usort($results, fn($a, $b) => (int)$b['scor'] - (int)$a['scor']);
    return $results;
}

function getAllPlacements(?string $search = null): array {
    $doc   = getXMLDoc();
    $xpath = new DOMXPath($doc);
    $nodes = $xpath->query('//placements/placement');
    $results = [];

    foreach ($nodes as $node) {
        $nume = $xpath->evaluate('string(nume)', $node);
        if ($search && stripos($nume, $search) === false) continue;

        $gameNode = $node->parentNode->parentNode;

        $results[] = [
            'id'       => $node->getAttribute('id'),
            'game'     => $gameNode->getAttribute('id'),
            'gameName' => $xpath->evaluate('string(n)', $gameNode),
            'imagine'  => $xpath->evaluate('string(imagine)', $node),
            'scor'     => $xpath->evaluate('string(scor)', $node),
            'nume'     => $nume,
        ];
    }
    return $results;
}

function addPlacement(string $gameId, string $imagine, string $scor, string $nume): void {
    $doc   = getXMLDoc();
    $xpath = new DOMXPath($doc);
    $placements = $xpath->query("//game[@id='$gameId']/placements")->item(0);

    if (!$placements) return;

    $allIds = $xpath->query('//placement/@id');
    $maxId  = 0;
    foreach ($allIds as $attr) {
        $maxId = max($maxId, (int)$attr->nodeValue);
    }

    $placement = $doc->createElement('placement');
    $placement->setAttribute('id', (string)($maxId + 1));
    $placement->appendChild($doc->createElement('imagine', htmlspecialchars($imagine)));
    $placement->appendChild($doc->createElement('scor',    htmlspecialchars($scor)));
    $placement->appendChild($doc->createElement('nume',    htmlspecialchars($nume)));
    $placements->appendChild($placement);
    
    saveXML($doc);
}

function getPlacementById(string $id): ?array {
    $doc   = getXMLDoc();
    $xpath = new DOMXPath($doc);
    $nodes = $xpath->query("//placement[@id='$id']");

    if ($nodes->length === 0) return null;
    $node = $nodes->item(0);
    $gameNode = $node->parentNode->parentNode;

    return [
        'id'      => $id,
        'game'    => $gameNode->getAttribute('id'),
        'imagine' => $xpath->evaluate('string(imagine)', $node),
        'scor'    => $xpath->evaluate('string(scor)', $node),
        'nume'    => $xpath->evaluate('string(nume)', $node),
    ];
}

function updatePlacement(string $id, string $scor, string $nume): void {
    $doc   = getXMLDoc();
    $xpath = new DOMXPath($doc);
    $nodes = $xpath->query("//placement[@id='$id']");

    if ($nodes->length === 0) return;
    $node = $nodes->item(0);

    $xpath->query('scor', $node)->item(0)->nodeValue = htmlspecialchars($scor);
    $xpath->query('nume', $node)->item(0)->nodeValue = htmlspecialchars($nume);

    saveXML($doc);
}

function deletePlacement(string $id): void {
    $doc   = getXMLDoc();
    $xpath = new DOMXPath($doc);
    $nodes = $xpath->query("//placement[@id='$id']");

    if ($nodes->length === 0) return;
    $node = $nodes->item(0);
    $node->parentNode->removeChild($node);

    saveXML($doc);
}

function addMessage(string $name, string $email, string $mesaj): void {
    $doc      = getXMLDoc();
    $xpath    = new DOMXPath($doc);
    $messages = $xpath->query('//messages')->item(0);

    if (!$messages) return;

    $allIds = $xpath->query('//message/@id');
    $maxId  = 0;
    foreach ($allIds as $attr) {
        $maxId = max($maxId, (int)$attr->nodeValue);
    }

    $msg = $doc->createElement('message');
    $msg->setAttribute('id', (string)($maxId + 1));
    $msg->appendChild($doc->createElement('name',  htmlspecialchars($name)));
    $msg->appendChild($doc->createElement('email', htmlspecialchars($email)));
    $msg->appendChild($doc->createElement('mesaj', htmlspecialchars($mesaj)));
    $messages->appendChild($msg);
    
    saveXML($doc);
}

function loadUsersFromXML(): array {
    $doc   = getXMLDoc();
    $xpath = new DOMXPath($doc);
    $nodes = $xpath->query('//users/user');
    $list  = [];

    foreach ($nodes as $node) {
        $list[] = [
            'username' => $xpath->evaluate('string(username)', $node),
            'password' => $xpath->evaluate('string(password)', $node),
            'role'     => $node->getAttribute('role'),
        ];
    }
    return $list;
}
