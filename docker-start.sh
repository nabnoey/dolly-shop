#!/bin/bash
# Doll Shop Docker Helper for Linux/Mac

while true; do
    clear
    echo "================================================="
    echo "    Doll Shop - Docker Management"
    echo "================================================="
    echo ""
    echo "1. Start Containers (docker-compose up)"
    echo "2. Stop Containers (docker-compose down)"
    echo "3. View Logs (docker-compose logs)"
    echo "4. Restart Containers"
    echo "5. Rebuild Images (docker-compose up --build)"
    echo "6. Execute Shell in PHP Container"
    echo "7. MySQL CLI"
    echo "8. Exit"
    echo ""
    read -p "Select option (1-8): " choice

    case $choice in
        1)
            clear
            echo ""
            echo "Starting Docker containers..."
            docker-compose up -d
            echo ""
            echo "✓ Containers started!"
            echo ""
            echo "Access the application at:"
            echo "  - Web: http://localhost"
            echo "  - Admin: http://localhost/admin"
            echo "  - phpMyAdmin: http://localhost:8080"
            echo ""
            read -p "Press Enter to continue..."
            ;;
        2)
            clear
            echo ""
            echo "Stopping Docker containers..."
            docker-compose down
            echo ""
            echo "✓ Containers stopped!"
            echo ""
            read -p "Press Enter to continue..."
            ;;
        3)
            clear
            echo ""
            echo "Showing docker logs (Ctrl+C to stop)..."
            docker-compose logs -f
            ;;
        4)
            clear
            echo ""
            echo "Restarting Docker containers..."
            docker-compose restart
            echo ""
            echo "✓ Containers restarted!"
            echo ""
            read -p "Press Enter to continue..."
            ;;
        5)
            clear
            echo ""
            echo "Rebuilding Docker images (this may take a while)..."
            docker-compose up -d --build
            echo ""
            echo "✓ Images rebuilt and containers started!"
            echo ""
            read -p "Press Enter to continue..."
            ;;
        6)
            clear
            echo ""
            echo "Executing shell in PHP container..."
            docker exec -it doll-shop-php bash
            ;;
        7)
            clear
            echo ""
            echo "Connecting to MySQL..."
            docker exec -it doll-shop-mysql mysql -u root -proot doll_shop
            ;;
        8)
            echo ""
            echo "Goodbye!"
            echo ""
            exit 0
            ;;
        *)
            echo "Invalid choice. Please try again."
            sleep 2
            ;;
    esac
done
