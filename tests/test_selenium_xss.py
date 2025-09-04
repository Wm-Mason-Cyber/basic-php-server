import pytest
import time
import shutil
import os
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.chrome.service import Service
from selenium.common.exceptions import NoAlertPresentException

BASE = 'http://localhost:8080/'
XSS_PAYLOAD = "<script>alert('XSS')</script>"

@pytest.fixture(scope="module")
def driver():
    options = Options()
    options.add_argument('--headless')
    options.add_argument('--disable-gpu')
    options.add_argument('--no-sandbox')
    # Explicitly set the Chromium binary location
    options.binary_location = shutil.which("chromium") or shutil.which("chromium-browser")
    chromedriver_path = shutil.which("chromedriver")
    if not chromedriver_path or not os.path.isfile(chromedriver_path):
        raise RuntimeError("chromedriver not found in PATH. Please install the correct version.")
    service = Service(chromedriver_path)
    driver = webdriver.Chrome(service=service, options=options)
    driver.set_window_size(1200, 800)
    yield driver
    driver.quit()

def test_navigation(driver):
    # Dismiss any leftover alerts from prior tests (defensive)
    try:
        driver.switch_to.alert.accept()
    except NoAlertPresentException:
        pass
    driver.get(BASE + 'index.php')
    nav_links = driver.find_elements(By.CSS_SELECTOR, 'nav a')
    expected = ['Home', 'About', 'Contact', 'Vulnerable', 'Safe', 'Stored-XSS (Vuln)', 'Stored-XSS (Safe)', 'SQLi (Vuln)', 'SQLi (Safe)', 'API']
    actual = [a.text for a in nav_links]
    assert actual == expected, f"Navigation links mismatch: {actual}"

def test_contact_xss(driver):
    try:
        driver.switch_to.alert.accept()
    except NoAlertPresentException:
        pass
    driver.get(BASE + 'contact.php')
    driver.find_element(By.ID, 'name').send_keys(XSS_PAYLOAD)
    driver.find_element(By.ID, 'message').send_keys(XSS_PAYLOAD)
    driver.find_element(By.CSS_SELECTOR, 'button[type=submit]').click()
    time.sleep(1)
    try:
        alert = driver.switch_to.alert
        alert_text = alert.text
        alert.accept()
        assert True, 'XSS alert triggered in submit.php (expected)'
    except:
        pytest.fail('No XSS alert in submit.php (should be vulnerable)')

def test_vulnerable_search_xss(driver):
    try:
        driver.switch_to.alert.accept()
    except NoAlertPresentException:
        pass
    driver.get(BASE + 'vulnerable.php')
    driver.find_element(By.ID, 'q').send_keys(XSS_PAYLOAD)
    driver.find_element(By.CSS_SELECTOR, 'button[type=submit]').click()
    time.sleep(1)
    try:
        alert = driver.switch_to.alert
        alert_text = alert.text
        alert.accept()
        assert True, 'XSS alert triggered in vulnerable.php (expected)'
    except:
        pytest.fail('No XSS alert in vulnerable.php (should be vulnerable)')

def test_safe_search_xss(driver):
    try:
        driver.switch_to.alert.accept()
    except NoAlertPresentException:
        pass
    driver.get(BASE + 'safe.php')
    driver.find_element(By.ID, 'q').send_keys(XSS_PAYLOAD)
    driver.find_element(By.CSS_SELECTOR, 'button[type=submit]').click()
    time.sleep(1)
    try:
        alert = driver.switch_to.alert
        alert_text = alert.text
        alert.accept()
        pytest.fail('XSS alert triggered in safe.php (should be safe)')
    except:
        assert True, 'No XSS alert in safe.php (expected)'
