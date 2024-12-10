import Box from "@mui/material/Box";

interface DeviceIconProps {
    iconName: string;
    online: boolean;
}

export default function DeviceIcon({iconName, online}: DeviceIconProps) {

    const getIcon = (): string => {
        if (iconName.length === 0) {
            return '';
        }
        return 'https://cameconnect.net/assets/images/sprites/' + iconName + '.png';
    }

    const styles = () => {
        return {
            display: "flex",
            alignItems: "center",
            justifyContent: "center",
            border: 2.75,
            width: '50px',
            height: '50px',
            borderRadius: 50,
            borderColor: online ? "#009EE0" : "red"
        }
    }


    return (
        <>
            <Box sx={styles()}>
                <img src={getIcon()} alt={"Device"}/>
            </Box>
        </>
    )
}
