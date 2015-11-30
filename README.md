# CityBuilder
Final project for CSCI3230U; a web application where users can watch their cities grow.

# Abstract
CityBuilder is a web application that allows users to create and grow their own
cities. They can choose to develop one of four sectors: residences, education,
recreation, or business. Sectors can be developed immediately through a
mouseclick or allowed to expand in real time. As the user's city improves it
will be given a description based on how the user has chosen to develop it.

# Game rules
The game progresses in 1 minute intervals, but can also be advanced through
mouseclicks. It operates on currencies of 'blocks' and 'dollars'. Each city
starts with a certain number of blocks, which are consumed to expand sectors.
Dollars are used to buy more blocks, and are earned over time depending on the
size of the sectors. The selected sector grows by 1 block for each mouseclick,
1 block for each minute passed.

# MySQL Component
The database will contain players and the cities attached to them.
    - Players have a username and a password used for login.
        - They also have a rank that reflects their best city.
    - Cities are owned by players. They have:
        - a name
        - number of blocks
        - number of dollars
        - timestamp of last refresh (used to calculate growth on next refresh)
        - number of blocks alloted to each sector
        - sector currently being expanded (can be null)

# PHP/PDO Component
The PHP will contain the logic to update and interpret the information 
contained in the database. It will encompass behaviours such as:
    - login
    - initializing new cities
    - updating cities based on the time that has passed since the last refresh
    - ensuring the city does not grow past it's number of blocks
    - updating the player's rank
    - mapping the sector & player rank values to approprate string descriptions
    
# jQuery/Javascript Component
jQuery will be used to add dynamic aspects to the page ranging from decorative
effects like fade-ins to keeping the page updated for each 1 minute frame of
the game.

# Other
It might be pertinent to include like a NES game password or something so that
users can resume their cities even if the server goes down, like a hash or
something. Ehh.