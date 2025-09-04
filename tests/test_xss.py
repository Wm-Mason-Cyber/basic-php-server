import requests
from urllib.parse import quote

BASE = 'http://localhost:8080/'
payload = "<script>alert('XSS')</script>"

def test_submit():
    url = BASE + 'submit.php?name=' + quote(payload) + '&message=' + quote(payload)
    r = requests.get(url)
    assert payload in r.text, 'submit.php should reflect input (XSS vulnerability expected)'

def test_vulnerable():
    url = BASE + 'vulnerable.php?q=' + quote(payload)
    r = requests.get(url)
    assert payload in r.text, 'vulnerable.php should reflect input (XSS vulnerability expected)'

def test_safe():
    url = BASE + 'safe.php?q=' + quote(payload)
    r = requests.get(url)
    assert payload not in r.text, 'safe.php should escape input (no XSS)'
