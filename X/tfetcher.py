
import sys
import requests
from bs4 import BeautifulSoup

def scrape_user_data(username):

    url = f"https://instalker.org/{username}"
    response = requests.get(url)

    soup = BeautifulSoup(response.content, "html.parser")

    avatar_img = soup.find("img", {"src": lambda x: x and "twimg.com" in x})["src"]
    user_handle = soup.find("h3").find("span", string=lambda x: x and x.startswith("@")).text
    username = soup.find("div", class_="my-dash-dt").find("h3").contents[0].text
    bio = soup.find("div", class_="my-dash-dt").find_all("span")[1].text
    follower_count = soup.select("ul.right-details > li:nth-of-type(2) > div.all-dis-evnt > div.dscun-numbr")[0].text
    following_count = soup.select("ul.right-details > li:nth-of-type(3) > div.all-dis-evnt > div.dscun-numbr")[0].text
    tweet_count = soup.select("ul.right-details > li:nth-of-type(1) > div.all-dis-evnt > div.dscun-numbr")[0].text

    if follower_count == '0' and following_count == '0' and tweet_count == '0':
        print("This account doesn't exist")
        return

    print("Avatar Image:", avatar_img)
    print("User Handle:", user_handle)
    print("Username:", username)
    print("User Bio:", bio)
    print("Follower Count:", follower_count)
    print("Following Count:", following_count)
    print("Tweets Count:", tweet_count)

if len(sys.argv) != 2:
    print("Please provide a username as an argument.")
    sys.exit(1)

username = sys.argv[1]
scrape_user_data(username)
